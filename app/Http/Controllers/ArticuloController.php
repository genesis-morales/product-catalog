<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use Illuminate\Http\Request;

class ArticuloController extends Controller
{
    public function index() {

        $articulos = Articulo::orderBy('id', 'desc')->paginate();
        return view('articulos.index', compact('articulos'));
    }

    public function create() {
        return view('articulos.create');
    }

    public function store(Request $request) { //Metodo POst
        $articulo = new Articulo();

        $articulo->nombre = $request->nombre;
        $articulo->nota = $request->nota;
        $articulo->tipo = $request->tipo;
        $articulo->precio = $request->precio;
        $articulo->fecha_vencimiento = $request->fecha_vencimiento;

        $articulo->save();

        return redirect()->route('articulos.show', $articulo);
    }

    public function show($id) {
        $articulo = Articulo::findOrFail($id); // Mejor usar findOrFail para evitar errores si no existe
        return view('articulos.show', compact('articulo'));
    }
    
}
