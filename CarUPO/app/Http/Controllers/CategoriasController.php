<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CategoriasController extends Controller
{
    function mostrarCategorias()
    {
        $categorias = Categoria::all();
        return view('categorias', @compact('categorias'));
    }

    public function addToCategorias(Request $request)
    {
        $reglas = [
            'nombre' => 'required|max:255',
        ];

        $mensajes = [
            'nombre.required' => 'El nombre es obligatorio.',
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        if ($validaciones->fails()) {
            return redirect()
                ->back()
                ->withErrors($validaciones)
                ->withInput();
        }

        $categoria = new Categoria();
        $categoria->nombre = $request->nombre;
        $categoria->save();
        return app()->make(CategoriasController::class)->callAction('mostrarCategorias', []);
    }


    public function removeToCategorias(Request $request)
    {
        $categoria = Categoria::findOrFail($request->id);
        $categoria->delete();
        return app()->make(CategoriasController::class)->callAction('mostrarCategorias', []);
    }
    
    public function editarCategoria(Request $request)
    {


        $reglas = [
            'nombre' => 'required|max:255',
        ];
        $mensajes = [
            'nombre.required' => 'El nombre es obligatorio.',
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        if ($validaciones->fails()) {
            return redirect()
                ->back()
                ->withErrors($validaciones)
                ->withInput();
        }

        $categoria = Categoria::findOrFail($request->id);
        $categoria->nombre = $request->nombre;
        $categoria->save();
        return app()->make(CategoriasController::class)->callAction('mostrarCategorias', []);
    }
}
