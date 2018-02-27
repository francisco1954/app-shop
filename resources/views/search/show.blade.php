@extends('layouts.app')

@section('title', 'Resultados de la búsqueda')

@section('body-class', 'profile-page')

@section('styles')
    <style>
        .team {
            padding-bottom: 50px;
        }

        .team .row .col-md-4 {
            margin-bottom: 5em;
        }

        .team .row {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            flex-wrap: wrap;
        }

        .row > [class*='col-'] {
            display: flex;
            flex-direction: column;
        }
    </style>
@endsection

@section('content')
<div class="header header-filter" style="background-image: url('/img/examples/city.jpg');"></div>

<div class="main main-raised">
    <div class="profile-content">
        <div class="container">
            <div class="row">
                <div class="profile">
                    <div class="avatar">
                        <img src="/img/lupa.jpg" alt="Imagen representativa de una lupa" class="img-circle img-responsive img-raised">
                    </div>

                    <div class="name">
                        <h3 class="title">Resultados de la búsqueda</h3>
                    </div>
                </div>

                @if (session('notificacion'))
                <div class=" text-center alert alert-success">
                {{ session('notificacion') }}
                </div>
                @endif
                
            </div>

            <div class="description text-center">
                <p>Se encontraron {{ $products->count() }} resultados para el término {{ $query }}</p>
            </div>

            <div class="team text-center">
                <div class="row">
                    @foreach ($products as $product)
                    <div class="col-md-4">
                        <div class="team-player">
                            <img src="{{ $product->featured_image_url }}" alt="Thumbnail Image" class="img-raised img-circle">
                            <h4 class="title">
                                <a href="{{ url('/products/' .$product->id) }}">{{ $product->name }}</a>
                            </h4>
                            <p class="description">{{ $product->description }}</p>
                            
                        </div>
                    </div>
                    @endforeach                    
                    
                </div>
                <div class="text-center">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

            

@include('includes.footer')
@endsection
