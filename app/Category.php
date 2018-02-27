<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public static $messages = [
            'name.required' => 'Es necesario ingresar el nombre de la nueva categoría.',
            'name.min' => 'El nombre de la categoría debe detener al menos tres caracteres.',
            'description.max' => 'La descripción solo admite hasta 250 caracteres.'
    ];

    public static $rules= [
        'name' => 'required|min:3',
        'description' => 'max:250'
    ];

    protected $fillable =['name', 'description'];

    // $category->products
    public function products()
    {
    	return $this->hasMany(Product::class);
    }

    public function getFeaturedImageUrlAttribute()
    {
        $featuredProduct = $this->products()->first();
        return $featuredProduct->featured_image_url;
    }
}
