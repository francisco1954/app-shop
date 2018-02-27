<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\User;
use App\Mail\NewOrder;
use Mail;

class CartController extends Controller
{
    public function update()
    {
    	$client = auth()->user();
    	$cart = $client->cart;
    	$cart->status = 'Pending';
    	$cart->order_date = Carbon::now();
    	$cart->save();  // Guardar en bbdd

    	$admins = User::where('admin', true)->get();
    	Mail::to($admins)->send(new NewOrder($client, $cart));

    	$notificacion = 'Su pedido se ha registrado correctamente. !Pronto recibirá un correo electrónico¡';
    	return back()->with(compact('notificacion'));
    }
}
