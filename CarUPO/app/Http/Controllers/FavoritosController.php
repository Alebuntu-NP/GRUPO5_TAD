<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favoritos;
use App\Models\Favorito_producto;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class FavoritosController extends Controller
{


    public function misFavoritos()
    {
        $id = Auth::user()->id;
        $favoritos = Favoritos::findOrFail($id);
        $productosFavoritos =
            Producto::join('favorito_productos', 'productos.id', '=', 'favorito_productos.fk_producto_id')
            ->join('favoritos', 'favorito_productos.fk_favorito_id', '=', 'favoritos.id')
            ->where('favoritos.fk_user', '=', $id)
            ->select('productos.*')
            ->paginate(8);
        return view('/misFavoritos', @compact('productosFavoritos'));
    }



    public function rankingFavoritos()
    {
        $productos = Producto::whereHas('favoritos_productos')->get();
        $productos = $productos->sortBy(function ($producto) {
            return count($producto->favoritos_productos) * -1;
        });
        return view('/favoritos', @compact('productos'));
    }

    public function addToFavoritos(Request $request)
    {

        $id = Auth::user()->id;
        $producto = Producto::findOrFail($request->idf);
        $es_favorito = DB::table('favoritos')
            ->join('favorito_productos', 'favoritos.id', '=', 'favorito_productos.fk_favorito_id')
            ->where('favorito_productos.fk_producto_id', '=', $producto->id)
            ->where('favoritos.fk_user', '=', Auth::id())
            ->exists();

        if (!$es_favorito) {
            $mi_favoritos = Favoritos::findOrFail($id);
            $favorito_producto = new Favorito_producto();
            $favorito_producto->fk_producto_id = $producto->id;
            $favorito_producto->fk_favorito_id = $mi_favoritos->id;
            $favorito_producto->save();
            $mi_favoritos->save();
        }

        if ($producto->coche != null) {
            $coche = $producto->coche;
            return view('mostrarCoche', @compact('coche'));
        } else {
            $accesorio = $producto->accesorio;
            return view('mostrarAccesorio', @compact('accesorio'));
        }
    }

    public function removeToFavoritos(Request $request)
    {
        $id = Auth::user()->id;
        $producto = Producto::findOrFail($request->idf);
        $es_favorito = DB::table('favoritos')
            ->join('favorito_productos', 'favoritos.id', '=', 'favorito_productos.fk_favorito_id')
            ->where('favorito_productos.fk_producto_id', '=', $producto->id)
            ->where('favoritos.fk_user', '=', Auth::id())
            ->exists();

        if ($es_favorito) {
            $mi_favoritos = Favoritos::findOrFail($id);
            $favorito_producto = Favorito_producto::where('fk_producto_id', '=', $producto->id)->where('fk_favorito_id', '=', $mi_favoritos->id)->first();
            $favorito_producto->delete();
        }
        if ($producto->coche != null) {
            $coche = $producto->coche;
            return view('mostrarCoche', @compact('coche'));
        } else {
            $accesorio = $producto->accesorio;
            return view('mostrarAccesorio', @compact('accesorio'));
        }
    }
}
