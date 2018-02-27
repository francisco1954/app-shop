<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class TestController extends Controller
{
	/*public function welcome()
	{
		$products = Product::paginate(9);
		return view('welcome')->with(compact('products'));
	}*/

	public function welcome()
	{
		$categories = Category::has('products')->get();
		return view('welcome')->with(compact('categories'));
	}
}