<?php

namespace App\Http\Controllers\Admin;

use App\Models\ForumComments;
use App\Models\Section;
use App\Models\User;
use App\Models\Category;
use App\Models\Forum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class ForumAdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $forum = Forum::withCount(['likes', 'dislikes'])->get();
        return view('admin.forum.index', compact('forum', 'user'));
    }

    public function view($id)
    {
        $user = Auth::user();
        try {
            $forum = Forum::find($id);
            $comments = ForumComments::where('forum_id', $id)->get();

            return view('admin.forum.view', compact('forum', 'user', 'comments'));
        } catch (\Exception $e) {
            return redirect('forum-admin')->with('status', 'Error al ver los comentarios de tema seleccionado.');
        }
    }

    public function destroy($id)
    {
        try {
            $forum = Forum::find($id);

            $forum_id = $forum->id;

            // Eliminar la imagen del foro si existe
            if ($forum->image) {
                $path = 'assets/uploads/forum/' . $forum_id;
                if (File::exists($path)) {
                    File::delete($path);
                }
            }
            // Eliminar los comentarios relacionados con el foro
            $forumcomments = ForumComments::where('forum_id', $id)->get();

            foreach ($forumcomments as $comment) {
                $comment->delete();
            }

            // Eliminar la sección del foro
            $forum->delete();

            return redirect('forum-admin')->with('status', 'Seccion del foro borrada correctamente');
        } catch (\Exception $e) {
            return redirect('forum-admin')->with('status', 'Error al intentar borrar la seccion del foro con el id: ' . $id);
        }
    }

    public function destroycomment($id, $id_comment)
    {
        try {
            $forumcomment = ForumComments::find($id_comment);
            $forumcomment->delete();
            return redirect()->back()->with('status', 'Comentario eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('status', 'Error al intentar eliminar el comentario.');
        }
    }




}