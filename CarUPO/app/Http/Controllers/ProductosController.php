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
        $productos = collect();
        if ($request->categoria == 0) {
            $productos = $todosP;
        } else {            
            foreach ($todosP as $product) {
                $categorias = $product->productos_categorias;
                foreach ($categorias as $cat) {                               
                    if ($cat->categoria->id == $request->categoria) {
                        $productos->push($product); 
                    }
                }            
            }
        }
        
        return view('productos', @compact('productos'));
    }
}
