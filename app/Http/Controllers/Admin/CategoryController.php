<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Product;
use File;


class CategoryController extends Controller
{
    public function index()
    {
    	$categories = Category::orderBy('id')->paginate(10);
    	return view('admin.categories.index')->with(compact('categories')); // listado 
    }

    public function create()
    {
    	return view('admin.categories.create'); // formulario de registro
    }

    public function store(Request $request)
    {
       	$this->validate($request, Category::$rules, Category::$messages);
       	// registrar en la bb.dd
    	$category = Category::create($request->only('name', 'description')); // asignación puntual de datos

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $path = public_path() . '/images/categories';
                $fileName = uniqid() . '-' .  $file->getClientOriginalName();
                $moved = $file->move($path, $fileName);

                // update category
                if ($moved) {
                    $category->image = $fileName;
                    $category->save();  //UPDATE
                }
            }
    	
    	return redirect('/admin/categories');
    }

    public function edit(Category $category)
    {
    	return view('admin.categories.edit')->with(compact('category')); // formulario de registro
    }

    public function update(Request $request, Category $category)
    {
        // validación de datos
        $this->validate($request, Category::$rules, Category::$messages);
        // registrar en nuevo producto en la bb.dd
    	$category->update($request->only('name', 'description'));

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = public_path() . '/images/categories';
            $fileName = uniqid() . '-' .  $file->getClientOriginalName();
            $moved = $file->move($path, $fileName);

            // update category
            if ($moved) {
                $previousPath = $path . '/' .$category->image;

                $category->image = $fileName;
                $saved = $category->save();  //UPDATE

                if ($saved)
                    File::delete($previousPath);
            }
        }
    	
    	return redirect('/admin/categories');
    }

    public function destroy(Category $category)
    {
    	Product::where('category_id', $category->id)->update(['category_id' => null]);

    	$category->delete(); // DELETE EN LA BB.DD.
    	return back();
    }
}


