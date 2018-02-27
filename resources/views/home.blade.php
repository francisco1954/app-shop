@extends('layouts.app')

@section('title', 'App Shop | Dashboard')

@section('body-class', 'product-page')

@section('content')

<style>
    .total {
        font-size: 1.5em;
    }
</style>
<div class="header header-filter" style="background-image: url('https://images.unsplash.com/photo-1423655156442-ccc11daa4e99?crop=entropy&dpr=2&fit=crop&fm=jpg&h=750&ixjsv=2.1.0&ixlib=rb-0.3.5&q=50&w=1450');">
</div>

<div class="main main-raised">
    <div class="container">
        
        <div class="section ">
            <h2 class="title text-center">Carrito de compras</h2>

            @if (session('notificacion'))
                <div class="text-center alert alert-success">
                    {{ session('notificacion') }}
                </div>
            @endif

            <ul class="nav nav-pills nav-pills-primary" role="tablist">
                <li class="active">
                    <a href="#dashboard" role="tab" data-toggle="tab">
                        <i class="material-icons">dashboard</i>
                        Carrito de compras
                    </a>
                </li>
                
                <li>
                    <a href="#tasks" role="tab" data-toggle="tab">
                        <i class="material-icons">list</i>
                        Pedidos realizados
                    </a>
                </li>
            </ul> 

            
            <hr>
            <p class="text-center">Su carrito de compras presenta {{ auth()->user()->cart->details->count() }} productos.</p>

            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">Imagen</th>
                        <th class="text-center">Nombre</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>SubTotal</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                @foreach (auth()->user()->cart->details as $detail)
                <tr>
                    <td class="text-center">
                        <img src="{{ $detail->product->featured_image_url }}" height="50">
                    </td>
                    <td class="text-center">
                        <a href="{{ url('/products/'.$detail->product->id) }}" target="_blank">{{ $detail->product->name }}</a>
                    </td>
                    <td> {{ $detail->product->price }}   &euro;</td>
                    <td> {{ $detail->quantity }}</td>
                    <td> {{ $detail->quantity * $detail->product->price }}   &euro;</td>
                    <td class="td-actions">
                        
                        <form method="post" action="{{ url('/cart') }}">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <input type="hidden" name="cart_detail_id" value="{{ $detail->id }}">

                            <a href="{{ url('/products/'.$detail->product->id) }}" target="_blank" rel="tooltip" title="Ver producto" class="btn btn-info btn-simple btn-xs">
                                <i class="fa fa-info"></i>
                            </a>
                            <button type="submit" rel="tooltip" title="Eliminar" class="btn btn-danger btn-simple btn-xs">
                                <i class="fa fa-times"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                    @endforeach
                </tbody>
            </table>
            <p class="text-center total"><strong>Importe a pagar: {{ auth()->user()->cart->total }} €</strong></p>

            <form method="post" action="{{ url('/order') }}">
                {{ csrf_field() }}
                <div class="text-center">
                    <button class="btn btn-primary">
                        <i class="material-icons">done</i> Realizar pedido
                    </button> 
                </div>
            </form>
              
        </div>

    </div>

</div>

@include('includes.footer')
@endsection

