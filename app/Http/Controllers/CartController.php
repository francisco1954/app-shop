<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function update()
    {
    	$cart = auth()->user()->cart;
    	$cart->status = 'Pending';
    	$cart->save();  // Guardar en bbdd

    	$notificacion = 'Su pedido se ha registrado correctamente. !Pronto recibirá un correo electrónico¡';
    	return back()->with(compact('notificacion'));
    }
}
