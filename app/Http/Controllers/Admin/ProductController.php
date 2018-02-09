<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    public function index()
    {
    	$products = Product::paginate(10);
    	return view('admin.products.index')->with(compact('products')); // listado 
    }

    public function create()
    {
    	return view('admin.products.create'); // formulario de registro
    }

    public function store(Request $request)
    {
        // validación de datos
        $messages = [
            'name.required' => 'Es necesario ingresar el nombre del nuevo producto.',
            'name.min' => 'El nombre del producto debe detener al menos tres caracteres.',
            'description.required' => 'La descripción corta es un campo obligatorio.',
            'description.max' => 'La descripción corta solo admite hasta 200 caracteres.',
            'price.required' => 'Es obligatorio definir un precio para el producto.',
            'price.numeric' => 'Ingrese un precio valido.',
            'price.min' => 'No se admiten valores negativos.'
        ];

        $rules= [
            'name' => 'required|min:3',
            'description' => 'required|max:200',
            'price' => 'required|numeric|min:0'
        ];

        $this->validate($request, $rules, $messages);

    	// registrar en nuevo producto en la bb.dd
    	//dd($request->all());
    	$product = new Product();
    	$product->name = $request->input('name');
    	$product->description = $request->input('description');
    	$product->price = $request->input('price');
    	$product->long_description = $request->input('long_description');
    	$product->save(); // INSERT EN LA BB.DD.

    	return redirect('/admin/products');
    }

    public function edit($id)
    {
    	//return "Mostrar aquí el form de edición para el producto con id igual a $id";

    	$product = Product::find($id);
    	return view('admin.products.edit')->with(compact('product')); // formulario de registro
    }

    public function update(Request $request, $id)
    {
        // validación de datos
        $messages = [
            'name.required' => 'Es necesario ingresar el nombre del nuevo producto.',
            'name.min' => 'El nombre del producto debe detener al menos tres caracteres.',
            'price.required' => 'Es obligatorio definir un precio para el producto.',
            'price.numeric' => 'Ingrese un precio valido.',
            'price.min' => 'No se admiten valores negativos para los precios.',
            'description.required' => 'La descripción corta es un campo obligatorio.',
            'description.max' => 'La descripción corta solo admite hasta 200 caracteres.'
            
        ];

        $rules= [
            'name' => 'required|min:3',
            'price' => 'required|numeric|min:0',
            'description' => 'required|max:200'
        ];

        $this->validate($request, $rules, $messages);

    	// registrar en nuevo producto en la bb.dd
    	//dd($request->all());
    	$product = Product::find($id);
    	$product->name = $request->input('name');
    	$product->description = $request->input('description');
    	$product->price = $request->input('price');
    	$product->long_description = $request->input('long_description');
    	$product->save(); // INSERT EN LA BB.DD.

    	return redirect('/admin/products');
    }

    public function destroy($id)
    {
    	//CartDetail::where('product_id', $id)->delete();
    	//ProductImage::where('product_id', $id)->delete();

    	$product = Product::find($id);
    	$product->delete(); // DELETE EN LA BB.DD.

    	return bach();
    }
}
