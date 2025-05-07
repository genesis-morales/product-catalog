@extends('layouts.plantilla')

@section('title', 'Producto: ' . $articulo->nombre)

@section('content')

    <h1>Producto: {{$articulo->nombre}}</h1>

    <a href="{{route('articulos.index')}}">Volver a listado de producto</a>

    <a href="{{ route('articulos.edit', $articulo->id) }}">Editar producto</a>

    <form action="{{ route('articulos.destroy', $articulo->id) }}" method="POST" style="display:inline">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?')">Eliminar producto</button>
    </form>
    



    <p><strong>Tipo de producto: </strong>{{$articulo->tipo}}</p>
    <p><strong>Precio: </strong>{{$articulo->precio}}</p>
    <p><strong>Nota adicional: </strong>{{$articulo->nota}}</p>
    <p><strong>Fecha de vencimiento: </strong>{{$articulo->fecha_vencimiento}}</p>


@endsection
