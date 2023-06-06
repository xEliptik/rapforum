<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function add($section_name)
    {

        $section = Section::where('name', $section_name)->where('status', '0')->first();
        $user = Auth::user();

        if ($section) {
            $section_id = $section->id;

            // Verificar si el usuario ya ha hecho un comentario previamente
            $existing_review = Review::where('user_id', $user->id)->where('section_id', $section_id)->first();

            if ($existing_review) {
                return redirect()->back()->with('status', 'Por favor, edita o elimina tu comentario anterior ya que has realizado uno previamente.');
            }

            return view('frontend.reviews.index', compact('section', 'user'));
        } else {
            return redirect()->back()->with('status', 'Se ha producido un error al comentar el elemento.');
        }
    }

    public function create(Request $request)
    {

        $section_id = $request->input('section_id');
        $section = Section::where('id', $section_id)->where('status', '0')->first();
        if ($section) {
            $user_review = $request->input('user_review');

            $new_review = Review::create([
                'user_id' => Auth::id(),
                'section_id' => $section_id,
                'user_review' => $user_review
            ]);
            $category_name = $section->category->name;
            $section_name = $section->name;
            if ($new_review) {
                return redirect('category/' . $category_name . '/' . $section_name)->with('status', 'Comentario publicado correctamete.');
            }
        } else {
            return redirect()->back()->with('status', 'Se ha producido un error en comentar el elemento.');
        }
    }

    public function edit($section_name)
    {
        $section = Section::where('name', $section_name)->where('status', '0')->first();
        $user = Auth::user();

        if ($section) {

            $section_id = $section->id;
            $review = Review::where('user_id', Auth::id())->where('section_id', $section_id)->first();
            if ($review) {
                return view('frontend.reviews.edit', compact('review', 'user'));
            } else {
                return redirect()->back()->with('status', 'Se ha producido un error en editar el comentario.');
            }

        }
    }

    public function update(Request $request)
    {
        $user_review = $request->input('user_review');
        if ($user_review != '') {
            $review_id = $request->input('review_id');
            $review = Review::where('id', $review_id)->where('user_id', Auth::id())->first();
            if ($review) {
                $review->user_review = $request->input('user_review');
                $review->update();
                return redirect('category/' . $review->section->category->name . '/' . $review->section->name)->with('status', 'Comentario actualizado correctamente');
            } else {
                return redirect()->back()->with('status', 'Se ha producido un error en editar el comentario.');
            }
        } else {
            return redirect()->back()->with('status', 'No se puede guardar un comentario vacio.');
        }
    }

    public function destroy($id)
    {
        try {
            $review = Review::find($id);
            $review->delete();
            return redirect('category/' . $review->section->category->name . '/' . $review->section->name)->with('status', 'Comentario borrado correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('status', 'No se puedo norrar el comentario.');
        }
    }
}