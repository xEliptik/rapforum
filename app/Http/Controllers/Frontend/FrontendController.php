<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Category;
use App\Models\Videoclip;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\ForumComments;

class FrontendController extends Controller
{
    /**
     * Método para mostrar la página de inicio
     * @return {View} La vista de la página de inicio
     */
    public function index()
    {
        $comments = ForumComments::select('forum_comments.*', DB::raw('COUNT(forum_comments_votes.type) as likes_count'))
            ->join('forum', 'forum_comments.forum_id', '=', 'forum.id')
            ->leftJoin('forum_comments_votes', 'forum_comments.id', '=', 'forum_comments_votes.comment_id')
            ->where('forum_comments_votes.type', 'like')
            ->groupBy('forum_comments.id')
            ->orderBy('likes_count', 'desc')
            ->take(4)
            ->get();

        $user = Auth::user(); // Obtener el usuario autenticado actualmente
        $featured_sections = Section::where('trending', '1')->take(15)->get();
        $trending_category = Category::where('popular', '1')->take(15)->get();
        return view('frontend.index', compact('user', 'featured_sections', 'trending_category', 'comments'));
    }


    public function category()
    {
        $user = Auth::user(); // Obtener el usuario autenticado actualmente
        $category = Category::where('status', '0')->get();
        $sectionstrending = Section::whereIn('cate_id', [1, 2, 3])
            ->where('position', 1)
            ->take(3)
            ->get();

        return view('frontend.category', compact('user', 'category', 'sectionstrending'));
    }

    public function viewcategory($name)
    {
        $user = Auth::user(); // Obtener el usuario autenticado actualmente
        if (Category::where('name', $name)->exists()) {
            $categoryName = Category::where('name', $name)->first();
            switch ($categoryName->name) {
                case 'Singers':
                    $columnName = 'Artista';
                    break;
                case 'Songs':
                    $columnName = 'Canción';
                    break;
                case 'Albums':
                    $columnName = 'Álbum';
                    break;
                case 'Noticias':
                    $columnName = 'Noticias';
                    break;
                default:
                    $columnName = 'Error';
                    break;
            }
            $category = Category::where('name', $name)->first();
            $cantidad = $category->count();
            $section = Section::where('cate_id', $category->id)->where('status', '0')
                ->orderBy('position')
                ->get();
            $cantidad = $section->count();
            if ($columnName == 'Noticias') {
                return view('frontend.sections.noticias', compact('user', 'category', 'section', 'columnName', 'cantidad'));
            } else {
                return view('frontend.sections.index', compact('user', 'category', 'section', 'columnName', 'cantidad'));
            }

        } else {
            return redirect('/')->with('status', 'El nombre no se pudo encontrar');
        }
    }

    public function sectionview($cate_name, $sect_name)
    {
        $user = Auth::user(); // Obtener el usuario autenticado actualmente
        $categories = Category::all();

        if (Category::where('name', $cate_name)->exists()) {
            if (Section::where('name', $sect_name)->exists()) {
                $section = Section::where('name', $sect_name)->first();
                $rating = Rating::where('section_id', $section->id)->get();
                $rating_sum = Rating::where('section_id', $section->id)->sum('stars_rated');
                $user_rating = Rating::where('section_id', $section->id)->where('user_id', Auth::id())->first();
                $reviews = Review::where('section_id', $section->id)->get();
                $noticia = Section::where('cate_id', 4)->inRandomOrder()->first();
                $noticia2 = Section::where('cate_id', 4)->where('id', '<>', $noticia->id)->inRandomOrder()->first();
                if ($rating->count() > 0) {
                    $rating_value = $rating_sum / $rating->count();
                } else {
                    $rating_value = 0;
                }

                if ($cate_name != 'Noticias') {
                    return view('frontend.sections.view', compact('user', 'section', 'rating', 'rating_value', 'user_rating', 'reviews', 'noticia', 'noticia2'));
                } else {
                    return view('frontend.sections.viewnoticia', compact('user', 'section', 'rating', 'rating_value', 'user_rating', 'reviews', 'noticia', 'noticia2'));
                }


            } else {
                return redirect('/')->with('status', 'El nombre del elemento no se pudo encontrar');
            }
        } else {
            return redirect('/')->with('status', 'El nombre de la categoria no se pudo encontrar');
        }
    }

    public function sectionlistAjax()
    {
        $sections = Section::select('categories.name as category', 'sections.name')
            ->join('categories', 'categories.id', '=', 'sections.cate_id')
            ->where('sections.status', '0');

        $videoclips = Videoclip::select(DB::raw("'Videoclip' as category"), 'song');

        $data = $sections->unionAll($videoclips)->get();

        $result = [];

        foreach ($data as $item) {
            $result[] = $item['category'] . ' - ' . $item['name'];
        }

        return $result;
    }


    public function searchSection(Request $request)
    {
        $searched_section = $request->section_name;

        if ($searched_section != "") {
            // Separa la cadena en dos partes, una para el nombre de la categoría y otra para el de la sección
            $parts = explode(" - ", $searched_section);
            if (count($parts) == 2) {
                $category_name = $parts[0];
                $section_name = $parts[1];
                // Busca la sección solo por su nombre, sin tener en cuenta la categoría
                $section = Section::where("name", "LIKE", "%$section_name%")->first();
                if ($section) {
                    // Verifica que la categoría a la que pertenece la sección sea la correcta
                    if ($section->category->name == $category_name) {
                        return redirect('category/' . $section->category->name . '/' . $section->name);
                    } else {
                        return redirect()->back()->with("status", "No se ha encontrado el elemento que has buscado.");
                    }
                } else {
                    return redirect()->back()->with("status", "No se ha encontrado el elemento que has buscado.");
                }
            } else {
                return redirect()->back()->with("status", "No se ha encontrado el elemento que has buscado.");
            }
        } else {
            return redirect()->back();
        }
    }


}