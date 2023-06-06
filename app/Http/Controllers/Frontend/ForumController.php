<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Forum;
use App\Models\ForumComments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Section;
use App\Models\ForumCommentsVotes;
use App\Models\ForumVotes;
use App\Models\Category;

class ForumController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $forum = Forum::all();
        $CommentsCount = [];
        foreach ($forum as $f) {
            $CommentsCount[$f->id] = ForumComments::where('forum_id', $f->id)->count();
        }
        $categories = Category::all();
        // Obtener los votos de tipo like y dislike para cada post

        $likesAndDislikes = $this->getLikesAndDislikes($forum);
        $categoriesWithCount = $this->getCategoriesWithCount($forum, $categories);
        return view('frontend.forum.index', compact('user', 'forum', 'categoriesWithCount', 'categories', 'likesAndDislikes', 'CommentsCount'));
    }

    public function view($id)
    {
        $user = Auth::user();
        $forum = Forum::find($id);
        $comments = ForumComments::where('forum_id', $id)->get();
        $commentsCount = ForumComments::where('forum_id', $id)->count();
        $likesAndDislikes = $this->getLikesAndDislikesComments($comments);
        $forumratio = $this->getLikesAndDislikes($forum);
        $categories = Category::all();
        $categoriesWithCount = $this->getCategoriesWithCount(Forum::all(), $categories);
        return view('frontend.forum.view', compact('user', 'forum', 'comments', 'categoriesWithCount', 'likesAndDislikes', 'forumratio', 'commentsCount'));
    }
    public function CommentsCount($forum)
    {
        try {
            $comment = ForumComments::selectRaw('forum_id, COUNT(*) as count')
                ->whereIn('forum_id', $forum->pluck('id'))
                ->groupBy('forum_id')
                ->get();

            $Comments = [];

            foreach ($forum as $f) {
                $commentCount = $comment->where('forum_id', $f->id)->pluck('count')->first();
                $Comments[$f->id] = $commentCount ? $commentCount : 0;
            }

            return $Comments;
        } catch (\Throwable $th) {
            return [];
        }
    }
    public function getLikesAndDislikes($forum)
    {
        try {
            $votes = ForumVotes::selectRaw('forum_id, type, COUNT(*) as count')
                ->whereIn('forum_id', $forum->pluck('id'))
                ->groupBy('forum_id', 'type')
                ->get();

            $likesAndDislikes = [];
            foreach ($votes as $vote) {
                if (!isset($likesAndDislikes[$vote->forum_id])) {
                    $likesAndDislikes[$vote->forum_id] = [
                        'likes' => 0,
                        'dislikes' => 0,
                    ];
                }

                if ($vote->type === 'like') {
                    $likesAndDislikes[$vote->forum_id]['likes'] = $vote->count;
                } elseif ($vote->type === 'dislike') {
                    $likesAndDislikes[$vote->forum_id]['dislikes'] = $vote->count;
                }
            }

            return $likesAndDislikes;
        } catch (\Throwable $th) {
            return [];
        }
    }


    public function getLikesAndDislikesComments($forum)
    {
        $votes = ForumCommentsVotes::selectRaw('comment_id, type, COUNT(*) as count')
            ->whereIn('comment_id', $forum->pluck('id'))
            ->groupBy('comment_id', 'type')
            ->get();

        $likesAndDislikes = [];
        foreach ($votes as $vote) {
            if (!isset($likesAndDislikes[$vote->comment_id])) {
                $likesAndDislikes[$vote->comment_id] = [
                    'likes' => 0,
                    'dislikes' => 0,
                ];
            }

            if ($vote->type === 'like') {
                $likesAndDislikes[$vote->comment_id]['likes'] = $vote->count;
            } elseif ($vote->type === 'dislike') {
                $likesAndDislikes[$vote->comment_id]['dislikes'] = $vote->count;
            }
        }

        return $likesAndDislikes;
    }




    public function add()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return redirect('forum')->with('status', 'Inicia sesión para poder añadir un nuevo tema al foro');
            }

            $forum = Forum::all();
            $comments = ForumComments::all();
            $categories = Category::all();
            $categoriesWithCount = $this->getCategoriesWithCount($forum, $categories);
            return view('frontend.forum.add', compact('user', 'forum', 'categoriesWithCount', 'comments', 'categories'));

        } catch (\Exception $e) {
            return redirect('forum')->with('status', 'Error al intentar añadir un nuevo tema al foro');
        }
    }


    public function insert(Request $request)
    {
        try {
            $forum = new Forum();
            $forum->user_id = $request->input('user_id');
            $forum->cate_id = $request->input('cate_id');
            $forum->title = $request->input('title');
            $forum->description = $request->input('description');

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = time() . '.' . $ext; // generar un nombre de archivo único utilizando la marca de tiempo actual
                $file->move('assets/uploads/forum/', $filename);
                $forum->image = $filename;
            }

            $forum->save(); // guardar el modelo para obtener su ID

            return redirect('forum')->with('status', 'Tema añadido correctamente');

        } catch (\Exception $e) {
            return redirect('forum')->with('status', 'Error al intentar añadir un nuevo tema en el foro');
        }
    }

    public function insertcomment(Request $request)
    {
        try {
            $forum = new ForumComments();
            $forum->user_id = $request->input('user_id');
            $forum->forum_id = $request->input('forum_id');
            $forum->comment = $request->input('comment');
            $forum->save(); // guardar el modelo para obtener su ID
            return redirect('forum/' . $forum->forum_id)->with('status', 'Comentario añadido correctamente');
        } catch (\Exception $e) {
            return redirect('forum/' . $forum->forum_id)->with('status', 'Error al intentar añadir un nuevo comentario');
        }
    }


    public function category($name)
    {
        $user = Auth::user();
        $category = Category::where('name', $name)->first();
        $forums = Forum::where('cate_id', $category->id)->get();
        $categories = Category::all();
        $categoriesWithCount = $this->getCategoriesWithCount(Forum::all(), $categories);
        $likesAndDislikes = $this->getLikesAndDislikes($forums);
        $CommentsCount = [];
        foreach ($forums as $f) {
            $CommentsCount[$f->id] = ForumComments::where('forum_id', $f->id)->count();
        }
        return view('frontend.forum.category', compact('user', 'forums', 'category', 'categoriesWithCount', 'likesAndDislikes', 'CommentsCount'));
    }
    public function like(Request $request, $id)
    {
        if (Auth::check()) {
            $user_id = $request->input('user_id');
            $forum_vote = ForumVotes::where('user_id', $user_id)->where('forum_id', $id)->first();

            if (!$forum_vote) {
                // El usuario no ha votado en este post antes, agregar nuevo voto
                $vote = new ForumVotes();
                $vote->user_id = $user_id;
                $vote->forum_id = $id;
                $vote->type = 'like';
                $vote->save();
            } elseif ($forum_vote->type == 'like') {
                // El usuario ha votado like antes, eliminar el voto
                $forum_vote->delete();
            } elseif ($forum_vote->type == 'dislike') {
                // El usuario ha votado dislike antes, cambiar su voto a like
                $forum_vote->type = 'like';
                $forum_vote->save();
            }
        }

        return redirect()->back();
    }

    public function dislike(Request $request, $id)
    {
        if (Auth::check()) {
            $user_id = $request->input('user_id');
            $forum_vote = ForumVotes::where('user_id', $user_id)->where('forum_id', $id)->first();

            if (!$forum_vote) {
                // El usuario no ha votado en este post antes, agregar nuevo voto
                $vote = new ForumVotes();
                $vote->user_id = $user_id;
                $vote->forum_id = $id;
                $vote->type = 'dislike';
                $vote->save();
            } elseif ($forum_vote->type == 'dislike') {
                // El usuario ha votado dislike antes, eliminar el voto
                $forum_vote->delete();
            } elseif ($forum_vote->type == 'like') {
                // El usuario ha votado like antes, cambiar su voto a dislike
                $forum_vote->type = 'dislike';
                $forum_vote->save();
            }
        }

        return redirect()->back();
    }

    public function likecomment(Request $request, $id)
    {
        if (Auth::check()) {
            $user_id = $request->input('user_id');
            $forum_vote = ForumCommentsVotes::where('user_id', $user_id)->where('comment_id', $id)->first();

            if (!$forum_vote) {
                // El usuario no ha votado en este post antes, agregar nuevo voto
                $vote = new ForumCommentsVotes();
                $vote->user_id = $user_id;
                $vote->comment_id = $id;
                $vote->type = 'like';
                $vote->save();
            } elseif ($forum_vote->type == 'like') {
                // El usuario ha votado like antes, eliminar el voto
                $forum_vote->delete();
            } elseif ($forum_vote->type == 'dislike') {
                // El usuario ha votado dislike antes, cambiar su voto a like
                $forum_vote->type = 'like';
                $forum_vote->save();
            }
        }

        return redirect()->back();
    }

    public function dislikecomment(Request $request, $id)
    {
        if (Auth::check()) {
            $user_id = $request->input('user_id');
            $forum_vote = ForumCommentsVotes::where('user_id', $user_id)->where('comment_id', $id)->first();

            if (!$forum_vote) {
                // El usuario no ha votado en este post antes, agregar nuevo voto
                $vote = new ForumCommentsVotes();
                $vote->user_id = $user_id;
                $vote->comment_id = $id;
                $vote->type = 'dislike';
                $vote->save();
            } elseif ($forum_vote->type == 'dislike') {
                // El usuario ha votado dislike antes, eliminar el voto
                $forum_vote->delete();
            } elseif ($forum_vote->type == 'like') {
                // El usuario ha votado like antes, cambiar su voto a dislike
                $forum_vote->type = 'dislike';
                $forum_vote->save();
            }
        }
        return redirect()->back();
    }

    private function getCategoriesWithCount($forum, $categories)
    {
        $categoriesWithCount = [];
        foreach ($categories as $category) {
            $count = $forum->where('cate_id', $category->id)->count();
            $categoriesWithCount[$category->name] = $count;
        }
        return $categoriesWithCount;
    }

    public function destroy($id)
    {
        try {
            ForumVotes::where('forum_id', $id)->delete();
            ForumCommentsVotes::whereIn('comment_id', function ($query) use ($id) {
                $query->select('id')->from('forum_comments')->where('forum_id', $id);
            })->delete();
            ForumComments::where('forum_id', $id)->delete();
            Forum::where('id', $id)->delete();
            return redirect('forum')->with('status', 'Tema eliminado correctamente.');
        } catch (\Throwable $th) {
            return redirect('forum')->with('status', 'Error en intentar borrar el tema del foro.');
        }
    }

    public function destroycomment($id)
    {
        try {
            ForumCommentsVotes::where('comment_id', $id)->delete();
            ForumComments::where('id', $id)->delete();
            return redirect('forum')->with('status', 'Comenario eliminado correctamente.');
        } catch (\Throwable $th) {
            return redirect('forum')->with('status', 'Error en intentar borrar el comenatrio.');
        }
    }

    public function forumlistAjax()
    {
        $sections = Forum::select('categories.name as category', 'forum.title')
            ->join('categories', 'categories.id', '=', 'forum.cate_id')
        ;

        $data = $sections->get();

        $result = [];

        foreach ($data as $item) {
            $result[] = $item['category'] . ' - ' . $item['title'];
        }

        return $result;
    }


    public function searchForum(Request $request)
    {
        $searched_section = $request->section_name;

        if ($searched_section != "") {
            // Separa la cadena en dos partes, una para el nombre de la categoría y otra para el de la sección
            $parts = explode(" - ", $searched_section);
            if (count($parts) == 2) {
                $category_name = $parts[0];
                $section_name = $parts[1];
                // Busca la sección solo por su nombre, sin tener en cuenta la categoría
                $section = Forum::where("title", "LIKE", "%$section_name%")->first();
                if ($section) {
                    // Verifica que la categoría a la que pertenece la sección sea la correcta
                    if ($section->category->name == $category_name) {
                        return redirect('forum/' . $section->id); // . $section->category->name . '/' . $section->name
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