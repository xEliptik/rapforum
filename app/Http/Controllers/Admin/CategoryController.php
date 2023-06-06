<?php

namespace App\Http\Controllers\Admin;

use App\Models\Section;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $category = Category::all();
        return view('admin.category.index', compact('category', 'user'));
    }

    public function add()
    {
        $user = Auth::user();
        return view('admin.category.add', compact('user'));
    }

    public function insert(Request $request)
    {
        try {
            $category = new Category();
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = time() . '.' . $ext;
                $file->move('assets/uploads/category/', $filename);
                $category->image = $filename;
            }
            $category->name = $request->input('name');
            $category->description = $request->input('description');
            $category->meta_description = $request->input('meta_description');
            $category->meta_title = $request->input('meta_title');
            $category->status = $request->input('status') == TRUE ? '1' : '0';
            $category->popular = $request->input('popular') == TRUE ? '1' : '0';
            $category->save();
            return redirect('categories')->with('status', 'Categoria añadida correctamente');
        } catch (\Exception $e) {
            return redirect('categories')->with('status', 'Ha habido un error al crear la categoria.');
        }
    }

    public function edit($id)
    {
        $user = Auth::user();
        try {
            $category = Category::find($id);
            return view('admin.category.edit', compact('category', 'user'));
        } catch (\Exception $e) {
            return redirect('categories')->with('status', 'Ha habido un error al modificar la categoria con el id: ' . $id);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $category = Category::find($id);
            if ($request->hasFile('image')) {
                $path = 'assets/uploads/category/' . $category->image;
                if (File::exists($path)) {
                    File::delete($path);
                }
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();
                $filename = time() . '.' . $ext;
                $file->move('assets/uploads/category/', $filename);
                $category->image = $filename;
            }
            $category->name = $request->input('name');
            $category->description = $request->input('description');
            $category->meta_description = $request->input('meta_description');
            $category->meta_title = $request->input('meta_title');
            $category->status = $request->input('status') == TRUE ? '1' : '0';
            $category->popular = $request->input('popular') == TRUE ? '1' : '0';
            $category->update();
            return redirect('categories')->with('status', 'Categoria modificado correctamente');
        } catch (\Exception $e) {
            return redirect('categories')->with('status', 'Ha habido un error al modificar la categoria con el id: ' . $id);
        }

    }
    public function destroy($id)
    {
        try {
            $category = Category::find($id);

            // Eliminar la imagen asociada a la categoría
            if ($category->image) {
                $path = 'assets/uploads/category/' . $category->image;
                if (File::exists($path)) {
                    File::delete($path);
                }
            }

            // Buscar y eliminar las secciones asociadas a la categoría
            $sections = Section::where('cate_id', $id)->get();
            foreach ($sections as $section) {
                // Eliminar la imagen asociada a la sección
                if ($section->image) {
                    $path = 'assets/uploads/section/' . $section->cate_id . '/' . $section->position . '.jpg';
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                }

                // Eliminar la sección
                $section->delete();
            }

            // Eliminar la categoría
            $category->delete();

            return redirect('categories')->with('status', 'Categoría borrada correctamente');
        } catch (\Exception $e) {
            return redirect('categories')->with('status', 'Error al intentar borrar la categoría con el ID: ' . $id);
        }
    }



}