<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Compra;

class ComprasController extends Controller
{
    public function mostrarCompras()
    {
        $compras = Compra::paginate(8);
        return view('compras', @compact('compras'));
    }

    public function mostrarCompra(Request $request)
    {
        $compra = Compra::findOrFail($request->id);
        return view('compra', @compact('compra'));
    }

    public function misCompras()
    {
        $compras = Compra::where('fk_user', Auth::id())->paginate(8);
        return view('misCompras', @compact('compras'));
    }

    public function actualizarEstado(Request $request)
    {
        $compra = Compra::findOrFail($request->id);
        $cadena_estado = $compra->estado;

        if ($cadena_estado == "Pendiente") {
            $cadena_estado = "Aceptado";
        } elseif ($cadena_estado == "Aceptado") {
            $cadena_estado = "En Camino";
        } elseif ($cadena_estado == "En Camino") {
            $cadena_estado = "Entregado";
        } elseif ($cadena_estado == "Entregado") {
            $cadena_estado = "Cerrado";
        }
        $compra->estado = $cadena_estado;

        $compra->save();

        return app()->make(ComprasController::class)->callAction('mostrarCompras', []);
    }
}
