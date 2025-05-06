@extends('layouts.plantilla')

@section('title', 'Productos create')

@section('content')
    <h1>Aqui podras agregar un producto</h1>

    <form action="{{ route('articulos.store') }}" method="POST">
        @csrf
    
        <div>
            <label for="nombre">Nombre:</label><br>
            <input type="text" id="nombre" name="nombre" required>
        </div>
    
        <div>
            <label for="nota">Nota:</label><br>
            <textarea id="nota" name="nota" rows="3"></textarea>
        </div>
    
        <div>
            <label for="tipo">Tipo:</label><br>
            <select id="tipo" name="tipo" required>
                <option value="abarrote">Abarrote</option>
                <option value="fruta">Fruta</option>
                <option value="verdura">Verdura</option>
                <option value="otro">Otro</option>
            </select>
        </div>
    
        <div>
            <label for="precio">Precio:</label><br>
            <input type="number" id="precio" name="precio" step="0.01" required>
        </div>
    
        <div>
            <label for="fecha_vencimiento">Fecha de vencimiento:</label><br>
            <input type="date" id="fecha_vencimiento" name="fecha_vencimiento">
        </div>
    
        <div style="margin-top: 1em;">
            <button type="submit">Guardar artículo</button>
        </div>
    </form>
    

@endsection
