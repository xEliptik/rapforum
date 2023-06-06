<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function users()
    {
        $users = User::all();
        $user = Auth::user(); // Obtener el usuario autenticado actualmente
        return view('admin.users.index', compact('users', 'user'));
    }

    public function edituser($id)
    {
        $user = User::find($id);
        return view('admin.users.edit', compact('user'));
    }


    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);

            if ($request->hasFile('image')) {
                $path = 'assets/uploads/user/' . $user->image;
                if (File::exists($path) & $user->image != "person.png") {
                    File::delete($path);
                }

                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = time() . '.' . $ext;
                $file->move('assets/uploads/user/', $filename);
                $user->image = $filename;
            }
            $user->name = $request->input('name');
            $user->role_as = $request->input('role_as') == TRUE ? '1' : '0';
            $user->email = $request->input('email');
            $user->username = $request->input('username');
            $user->update();
            return redirect('users')->with('status', 'Usuario modificado correctamente');
        } catch (\Exception $e) {
            return redirect('edit-user/' . $id)->with('status', 'Ha habido un error. No puedes tener un nombre de usuario o email ya existente');
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::find($id);

            if ($user->image) {
                $path = 'assets/uploads/user/' . $user->image;
                if (File::exists($path) & $user->image != "person.png") {

                    File::delete($path);
                }
            }
            $user->delete();
            return redirect('users')->with('status', 'Usuario borrado correctamente');
        } catch (\Exception $e) {
            return redirect('users')->with('status', 'Error al intentar borrar el usuario con id: ' . $id);
        }
    }

    public function add()
    {
        $users = User::all();
        $user = Auth::user(); // Obtener el usuario autenticado actualmente
        return view('admin.users.add', compact('user', 'user'));
    }


    public function insert(Request $request)
    {
        try {
            $user = new User();
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = $request->input('username') . '.' . $ext; // usar el nombre de usuario para nombrar la imagen
                $file->move('assets/uploads/user/', $filename);
                $user->image = $filename;
            }
            $user->name = $request->input('name');
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            $user->role_as = $request->input('role_as') == TRUE ? '1' : '0';
            if ($request->input('password') === $request->input('password1')) {
                // passwords match, proceed with saving user
                $user->password = bcrypt($request->input('password'));
                $user->save();
                // ... rest of the code for saving user
            } else {
                // passwords don't match, show error message or redirect back to form
                return redirect('users')->with('status', 'Las contraseñas no coinciden');
            }

            return redirect('users')->with('status', 'Seccion añadido correctamente');
        } catch (\Exception $e) {
            return redirect('users')->with('status', 'Error al añadir un elemento');
        }
    }
}