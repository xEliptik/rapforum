<?php

namespace App\Http\Controllers\Admin;

use App\Models\Videoclip;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class VideoclipController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $videoclip = Videoclip::all();
        return view('admin.videoclip.index', compact('videoclip', 'user'));
    }

    public function add()
    {
        $user = Auth::user();
        return view('admin.videoclip.add', compact('user'));
    }

    public function insert(Request $request)
    {
        try {
            $videoclip = new Videoclip();
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = time() . '.' . $ext;
                $file->move('assets/uploads/videoclip/', $filename);
                $videoclip->image = $filename;
            }
            $videoclip->song = $request->input('song');
            $videoclip->singer = $request->input('singer');
            $videoclip->description = $request->input('description');
            $videoclip->views = $request->input('views');
            $videoclip->award = $request->input('award') == TRUE ? '1' : '0';
            $videoclip->save();
            return redirect('videoclips')->with('status', 'Videoclip añadido correctamente');
        } catch (\Exception $e) {
            return redirect('videoclips')->with('status', 'Error al añadir el videoclip');

        }
    }

    public function destroy($id)
    {
        try {
            $videoclips = Videoclip::find($id);

            if ($videoclips->image) {
                $path = 'assets/uploads/videoclip/' . $videoclips->image;
                if (File::exists($path)) {

                    File::delete($path);
                }
            }
            $videoclips->delete();
            return redirect('videoclips')->with('status', 'Videoclip borrado correctamente');
        } catch (\Exception $e) {
            return redirect('videoclips')->with('status', 'Error al intentar borrar el videoclip con el id: ' . $id);
        }
    }

    public function edit($id)
    {
        $user = Auth::user();
        try {
            $videoclip = Videoclip::find($id);
            return view('admin.videoclip.edit', compact('videoclip', 'user'));
        } catch (\Exception $e) {
            return redirect('videoclips')->with('status', 'Error al modificar el videoclip con el id ' . $id);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $videoclips = Videoclip::find($id);

            if ($request->hasFile('image')) {
                $path = 'assets/uploads/videoclip/' . $videoclips->image;
                if (File::exists($path)) {
                    File::delete($path);
                }
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = time() . '.' . $ext;
                $file->move('assets/uploads/videoclip/', $filename);
                $videoclips->image = $filename;
            }


            $videoclips->song = $request->input('song');
            $videoclips->singer = $request->input('singer');
            $videoclips->description = $request->input('description');
            $videoclips->award = $request->input('award') == TRUE ? '1' : '0';

            $videoclips->update();
            return redirect('videoclips')->with('status', 'Videoclip modificado correctamente');
        } catch (\Exception $e) {
            return redirect('videoclips')->with('status', 'Error al modificar el videoclip con el id ' . $id);
        }
    }

}