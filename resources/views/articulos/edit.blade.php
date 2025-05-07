@extends('layouts.plantilla')

@section('title', 'Productos create')

@section('content')
<h1>Aquí podrás editar un producto</h1>

<form action="{{ route('articulos.update', $articulo->id) }}" method="POST">

    @csrf
    @method('PUT')

    <div>
        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" required value="{{ $articulo->nombre }}">
    </div>

    <div>
        <label for="nota">Nota:</label><br>
        <textarea id="nota" name="nota" rows="3">{{ $articulo->nota }}</textarea>
    </div>

    <div>
        <label for="tipo">Tipo:</label><br>
        <select id="tipo" name="tipo" required>
            <option value="abarrote" {{ $articulo->tipo == 'abarrote' ? 'selected' : '' }}>Abarrote</option>
            <option value="fruta" {{ $articulo->tipo == 'fruta' ? 'selected' : '' }}>Fruta</option>
            <option value="verdura" {{ $articulo->tipo == 'verdura' ? 'selected' : '' }}>Verdura</option>
            <option value="otro" {{ $articulo->tipo == 'otro' ? 'selected' : '' }}>Otro</option>
        </select>
    </div>

    <div>
        <label for="precio">Precio:</label><br>
        <input type="number" id="precio" name="precio" step="0.01" required value="{{ $articulo->precio }}">
    </div>

    <div>
        <label for="fecha_vencimiento">Fecha de vencimiento:</label><br>
        <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" 
            value="{{ $articulo->fecha_vencimiento ? \Carbon\Carbon::parse($articulo->fecha_vencimiento)->format('Y-m-d') : '' }}">
    </div>

    <div style="margin-top: 1em;">
        <button type="submit">Editar artículo</button>
    </div>
</form>


@endsection
