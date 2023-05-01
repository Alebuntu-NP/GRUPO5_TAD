<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    public function mostrarProductos()
    {
        $productos = Producto::paginate(8);
        return view('productos', @compact('productos'));
    }

    public function filtrarProductos(Request $request)
    {
        $todosP = Producto::paginate(8);
        if ($request->categoria == 0) {
            $productos = $todosP;
        } else {
            $productos =
                Producto::join('producto_categorias', 'productos.id', '=', 'producto_categorias.fk_producto_id')
                ->join('categorias', 'producto_categorias.fk_categoria_id', '=', 'categorias.id')
                ->where('categorias.id', '=', $request->categoria)
                ->select('productos.*')
                ->paginate(8);
        }

        return view('productos', @compact('productos'));
    }
}
