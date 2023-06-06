<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Forum;
use App\Models\Section;
use App\Models\Category;
use App\Models\Videoclip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Obtener el usuario autenticado actualmente
        $users = User::all()->count();
        $sections = Section::all()->count();
        $categories = Category::all()->count();
        $forum = Forum::all()->count();
        $videoclip = Videoclip::all()->count();
        return view('admin.index', compact('users', 'user', 'categories', 'sections', 'forum', 'videoclip'));
    }


}