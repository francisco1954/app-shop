<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Product;


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
    	Category::create($request->all()); // asignación masiva de datos
    	
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
    	$category->update($request->all());
    	
    	return redirect('/admin/categories');
    }

    public function destroy(Category $category)
    {
    	Product::where('category_id', $category->id)->update(['category_id' => null]);

    	$category->delete(); // DELETE EN LA BB.DD.
    	return back();
    }
}


