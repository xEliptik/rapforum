<?php

namespace App\Http\Controllers\Admin;

use App\Models\Section;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $sections = Section::all();
        return view('admin.section.index', compact('sections', 'user'));
    }

    public function add()
    {
        $user = Auth::user();
        $categories = Category::all();
        return view('admin.section.add', compact('categories', 'user'));
    }

    public function insert(Request $request)
    {
        try {

            $sections = new Section();
            $sections->position = $request->input('position');
            $sections->cate_id = $request->input('cate_id');
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = strval($sections->position) . '.' . $ext;
                $file->move('assets/uploads/section/' . strval($sections->cate_id) . '/', $filename);
                $sections->image = $filename;
            }
            $sections->name = $request->input('name');
            $sections->small_description = $request->input('small_description');
            $sections->description = $request->input('description');
            $sections->status = $request->input('status') == TRUE ? '1' : '0';
            $sections->trending = $request->input('trending') == TRUE ? '1' : '0';
            $sections->meta_title = $request->input('meta_title');
            $sections->meta_keywords = $request->input('meta_keywords');
            $sections->meta_description = $request->input('meta_description');
            $sections->save();
            return redirect('sections')->with('status', 'Seccion añadido correctamente');
        } catch (\Exception $e) {
            return redirect('sections')->with('status', 'Error al añadir un elemento');

        }
    }

    public function edit($id)
    {
        $user = Auth::user();
        try {
            $sections = Section::find($id);
            $category = Category::all();
            return view('admin.section.edit', compact('sections', 'category', 'user'));
        } catch (\Exception $e) {
            return redirect('sections')->with('status', 'Error al modificar el elemento con el id ' . $id);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $sections = Section::find($id);
            $sections->cate_id = $request->input('cate_id');
            $sections->position = $request->input('position');
            if ($request->hasFile('image')) {
                $path = 'assets/uploads/section/' . strval($sections->cate_id) . '/' . $sections->image;
                if (File::exists($path)) {
                    File::delete($path);
                }
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = strval($sections->position) . '.' . $ext;
                $file->move('assets/uploads/section/' . strval($sections->cate_id) . '/', $filename);
                $sections->image = $filename;
            }


            $sections->name = $request->input('name');
            $sections->small_description = $request->input('small_description');
            $sections->description = $request->input('description');
            $sections->status = $request->input('status') == TRUE ? '1' : '0';
            $sections->trending = $request->input('trending') == TRUE ? '1' : '0';
            $sections->meta_title = $request->input('meta_title');
            $sections->meta_keywords = $request->input('meta_keywords');
            $sections->meta_description = $request->input('meta_description');

            $sections->update();
            return redirect('sections')->with('status', 'Seccion modificada correctamente');
        } catch (\Exception $e) {
            return redirect('sections')->with('status', 'Error al modificar el elemento con el id ' . $id);
        }
    }

    public function destroy($id)
    {
        try {
            $sections = Section::find($id);
            $position = $sections->position;
            $cate_id = $sections->cate_id;

            if ($sections->image) {
                $path = 'assets/uploads/section/' . $cate_id . '/' . $position . '.' . pathinfo($sections->image, PATHINFO_EXTENSION);
                if (File::exists($path)) {
                    File::delete($path);
                }
            }
            $sections->delete();
            return redirect('sections')->with('status', 'Seccion borrada correctamente');
        } catch (\Exception $e) {
            return redirect('sections')->with('status', 'Error al intentar borrar el elemento con el id: ' . $id);
        }
    }

    public function showCategory($categoryName)
    {
        $users = User::all();
        $category = Category::where('name', $categoryName)->firstOrFail();
        $section = Section::where('cate_id', $category->id)->orderBy('position', 'asc')->get();
        $columnName = ($categoryName === 'artists') ? 'Song' : 'Album'; // cambiar el nombre de la columna según la categoría
        return view('category.show', compact('category', 'section', 'columnName', 'user'));
    }
}