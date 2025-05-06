@extends('layouts.plantilla')

@section('title', 'Productos')

@section('content')
    <h1>Bienvenido a la página principal de productos</h1>

    <a href="{{route('articulos.create')}}">Añadir producto</a>

    <ul>
        @foreach ($articulos as $articulo)
            <li>
                <a href="{{route('articulos.show', $articulo->id)}}">{{$articulo->nombre}}</a>
            </li> {{-- Asegúrate de usar el campo correcto --}}
        @endforeach
    </ul>

    {$articulos->links()}

@endsection
