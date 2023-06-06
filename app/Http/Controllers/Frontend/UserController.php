<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{



    public function user($username)
    {
        if (User::where('username', $username)->exists()) {
            $user = User::where('username', $username)->first();

            $likedSections = $user->ratings()->with('section')->get()->pluck('section');

            if ($user->google_id === null) {
                return view('frontend.users.index', compact('user', 'likedSections'));
            } else {
                return view('frontend.users.indexgoogle', compact('user', 'likedSections'));
            }
        } else {
            return view('frontend.index', compact('user'));
        }
    }







    public function update(Request $request, $id)
    {
        $user = User::find($id);
        try {
            if ($request->hasFile('image')) {
                $path = 'assets/uploads/user/' . $user->image;
                if (File::exists($path) && $user->image != "person.png") {
                    File::delete($path);
                }
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = time() . '.' . $ext;
                $file->move('assets/uploads/user/', $filename);
                $user->image = $filename;
            }

            $user->name = $request->input('name');
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            $new_password = $request->input('newpassword');
            $new_password2 = $request->input('newpassword2');

            if ($new_password == $new_password2) { //canviar a nou password
                if (Hash::check($request->input('password'), $user->password)) {
                    $user->password = bcrypt($new_password); //encripta nou password
                } else {
                    return redirect('user/' . $user->username)->with('status', 'La contraseña no se pudo cambiar.');
                }
            } else {
                return redirect('user/' . $user->username)->with('status', 'La nueva contraseña no se escribió correctamente.');
            }
            $user->update();
            return redirect('user/' . $user->username)->with('status', 'Usuario modificado correctamente');
        } catch (\Exception $e) {
            return redirect('user/' . $user->username)->with('status', 'Error al modificar el usuario');
        }
    }

    public function updategoogle(Request $request, $id)
    {
        $user = User::find($id);
        try {
            if ($request->hasFile('image')) {
                $path = 'assets/uploads/user/' . $user->image;
                if (File::exists($path) && $user->image != "person.png") {
                    File::delete($path);
                }
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = time() . '.' . $ext;
                $file->move('assets/uploads/user/', $filename);
                $user->image = $filename;
            }

            $user->name = $request->input('name');
            $user->username = $request->input('username');

            $user->update();
            return redirect('user/' . $user->username)->with('status', 'Usuario modificado correctamente');
        } catch (\Exception $e) {
            return redirect('user/' . $user->username)->with('status', 'Error al modificar el usuario');
        }
    }



}