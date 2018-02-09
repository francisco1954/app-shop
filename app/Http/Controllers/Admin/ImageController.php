<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Product;
use App\ProductImage;
use File;

class ImageController extends Controller
{
    public function index($id)
    {
    	$product = Product::find($id);
    	$images = $product->images()->orderBy('featured' ,'desc')->get();
    	return view('admin.products.images.index')->with(compact('product', 'images'));
    }

    public function store(Request $request, $id)
    {
    	// guardar imagen en nuestro proyecto
    	$file = $request->file('photo');
    	$path = public_path() . '/images/products';
    	$fileName = uniqid() . $file->getClientOriginalName();
    	$move = $file->move($path, $fileName);

    	// crar un registro en la table product_images
    	if ($move) {
			$productImage = new ProductImage();
			$productImage->image = $fileName;
			//$productImage->feature = false;
			$productImage->product_id = $id;
			$productImage->save();  //INSERT
		}

    	return back();
    }

    public function destroy(Request $request, $id)
    {
    	// 1º eliminar el archivo en el proyecto
    	$productImage = ProductImage::find($request->image_id);
    	if (substr($productImage->image, 0, 4) === "http") {
    		$deleted = true;
    	} else {
    		$fullPath = public_path() . '/images/products/' . $productImage->image;
    		$deleted = File::delete($fullPath);
    	}

    	// 2º eliminar el archivo en la bbdd
    	if ($deleted) {
    		$productImage->delete();
    	}

    	return back();
    }

    public function select($id, $image)
    {
        ProductImage::where('product_id', $id)->update([
            'featured' =>false
        ]);

        $productImage = ProductImage::find($image);
        $productImage->featured = true;
        $productImage->save();

        return back();
    }


}
