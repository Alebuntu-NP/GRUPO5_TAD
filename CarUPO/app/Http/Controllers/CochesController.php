<?php

namespace App\Http\Controllers;

use App\Models\Coche;
use App\Models\Producto;
use App\Models\Producto_categoria;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CochesController extends Controller
{

    public function crearCoche(Request $request)
    {
        $reglas = [
            'descripcion' => 'required|max:255',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'precio' => ['required', 'numeric', 'regex:/^\d{1,6}(\.\d{1,2})?$/'],
            'marca' => 'required|max:255',
            'modelo' => 'required|max:255',
            'color' => 'required|max:255',
            'combustible' => 'required|max:255',
            'cilindrada' => ['required', 'numeric', 'regex:/^\d{1,6}(\.\d{1,2})?$/'],
            'potencia' => ['required', 'numeric', 'regex:/^\d{1,6}(\.\d{1,2})?$/'],
            'nPuertas' => 'required|numeric|in:2,3,4,5',

        ];

        $mensajes = [
            'descripcion.required' => 'La descripción es obligatoria',
            'foto.required' => 'La foto es obligatoria.',
            'foto.image' => 'El archivo debe ser una imagen.',
            'foto.mimes' => 'El archivo debe ser de tipo JPEG, PNG, JPG, GIF o SVG.',
            'foto.max' => 'El tamaño máximo del archivo es de 2 MB.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.regex' => 'El precio debe tener un formato válido (máximo de 6 dígitos enteros y hasta 2 decimales después del punto).',
            'marca.required' => 'La marca es obligatoria',
            'modelo.required' => 'El modelo es obligatorio',
            'color.required' => 'El color es obligatorio',
            'combustible.required' => 'El combustible es obligatorio',
            'cilindrada.required' => 'El precio es obligatorio.',
            'cilindrada.numeric' => 'El precio debe ser un número.',
            'cilindrada.regex' => 'La cilindrada debe tener un formato válido (máximo de 6 dígitos enteros y hasta 2 decimales después del punto).',
            'potencia.required' => 'El precio es obligatorio.',
            'potencia.numeric' => 'El precio debe ser un número.',
            'potencia.regex' => 'La potencia debe tener un formato válido (máximo de 6 dígitos enteros y hasta 2 decimales después del punto).',
            'nPuertas.required' => 'El número de puertas es obligatorio.',
            'nPuertas.numeric' => 'El número de puertas debe ser un número.',
            'nPuertas.in' => 'El número de puertas debe ser 2, 3, 4 o 5.',
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        if ($validaciones->fails()) {
            return redirect()
                ->back()
                ->withErrors($validaciones)
                ->withInput();
        }

        $producto = new Producto();
        $producto->descripcion = $request->descripcion;
        $nfoto = 'images/' . $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], $nfoto);
        $producto->foto = $nfoto;
        $producto->precio = $request->precio;
        $producto->save();
        if ($request->categorias != null) {
            foreach ($request->categorias as $categoria) {
                $producto_categoria = new Producto_categoria();
                $producto_categoria->fk_producto_id = $producto->id;
                $producto_categoria->fk_categoria_id = $categoria;
                $producto_categoria->save();
            }
        }


        $coche = new Coche();
        $coche->marca = $request->marca;
        $coche->modelo = $request->modelo;
        $coche->color = $request->color;
        $coche->combustible = $request->combustible;
        $coche->cilindrada = $request->cilindrada;
        $coche->potencia = $request->potencia;
        $coche->nPuertas = $request->nPuertas;
        $coche->fk_producto_id = $producto->id;
        $coche->save();
        return app()->make(ProductosController::class)->callAction('mostrarProductos', []);
    }

    public function verBorrarCoche(Request $request)
    {
        $coche = Coche::findOrFail($request->id);
        return view('borrarCoche', @compact('coche'));
    }

    public function verMostrarCoche(Request $request)
    {
        $coche = Coche::find($request->id);
        return view('mostrarCoche', @compact('coche'));
    }

    public function verEditarCoche(Request $request)
    {
        $coche = Coche::findOrFail($request->id);
        return view('editarCoche', @compact('coche'));
    }

    public function editarCoche(Request $request)
    {

        $reglas = [
            'descripcion' => 'required|max:255',
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'precio' => ['required', 'numeric', 'regex:/^\d{1,6}(\.\d{1,2})?$/'],
            'marca' => 'required|max:255',
            'modelo' => 'required|max:255',
            'color' => 'required|max:255',
            'combustible' => 'required|max:255',
            'cilindrada' => ['required', 'numeric', 'regex:/^\d{1,6}(\.\d{1,2})?$/'],
            'potencia' => ['required', 'numeric', 'regex:/^\d{1,6}(\.\d{1,2})?$/'],
            'nPuertas' => 'required|numeric|in:2,3,4,5',
        ];

        $mensajes = [
            'descripcion.required' => 'La descripción es obligatoria',
            'foto.image' => 'El archivo debe ser una imagen.',
            'foto.mimes' => 'El archivo debe ser de tipo JPEG, PNG, JPG, GIF o SVG.',
            'foto.max' => 'El tamaño máximo del archivo es de 2 MB.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número.',
            'precio.regex' => 'El precio debe tener un formato válido (máximo de 6 dígitos enteros y hasta 2 decimales después del punto).',
            'marca.required' => 'La marca es obligatoria',
            'modelo.required' => 'El modelo es obligatorio',
            'color.required' => 'El color es obligatorio',
            'combustible.required' => 'El combustible es obligatorio',
            'cilindrada.required' => 'El precio es obligatorio.',
            'cilindrada.numeric' => 'El precio debe ser un número.',
            'cilindrada.regex' => 'La cilindrada debe tener un formato válido (máximo de 6 dígitos enteros y hasta 2 decimales después del punto).',
            'potencia.required' => 'El precio es obligatorio.',
            'potencia.numeric' => 'El precio debe ser un número.',
            'potencia.regex' => 'La potencia debe tener un formato válido (máximo de 6 dígitos enteros y hasta 2 decimales después del punto).',
            'nPuertas.required' => 'El número de puertas es obligatorio.',
            'nPuertas.numeric' => 'El número de puertas debe ser un número.',
            'nPuertas.in' => 'El número de puertas debe ser 2, 3, 4 o 5.',
        ];

        $validaciones = Validator::make($request->all(), $reglas, $mensajes);

        if ($validaciones->fails()) {
            return redirect()
                ->route("ver.coche.editar", ['id' => $request->id])
                ->withErrors($validaciones)
                ->withInput();
        }

        $coche = Coche::findOrFail($request->id);
        $producto = $coche->producto;
        $producto->descripcion = $request->descripcion;
        $nfoto = $_FILES['foto']['name'];
        if ($nfoto != "") {
            move_uploaded_file($_FILES['foto']['tmp_name'], 'images/' . $nfoto);
            $producto->foto = 'images/' . $nfoto;
        }
        $producto->precio = $request->precio;
        $producto->save();

        $categorias_usadas = Producto_categoria::where('fk_producto_id', '=', $producto->id)->get();



        if ($request->categorias != null) {
            foreach ($request->categorias as $categoria) {
                $producto_categoria = new Producto_categoria();
                $producto_categoria->fk_producto_id = $producto->id;
                $producto_categoria->fk_categoria_id = $categoria;
                $producto_categoria->save();
            }
        }
        foreach ($categorias_usadas as $categoria) {
            $categoria->delete();
        }

        $coche->marca = $request->marca;
        $coche->modelo = $request->modelo;
        $coche->color = $request->color;
        $coche->combustible = $request->combustible;
        $coche->cilindrada = $request->cilindrada;
        $coche->potencia = $request->potencia;
        $coche->nPuertas = $request->nPuertas;
        $coche->fk_producto_id = $producto->id;
        $coche->save();
        return app()->make(ProductosController::class)->callAction('mostrarProductos', []);
    }
    public function eliminarCoche(Request $request)
    {

        $coche = Coche::findOrFail($request->id);
        $producto = $coche->producto;
        if ($producto->lineas_de_compra->count() > 0) {
            return redirect()->back()->with('error', 'No se puede eliminar el coche porque está asociado a lineas de compra.');
        }
        if ($producto->lineas_de_carrito->count() > 0) {
            return redirect()->back()->with('error', 'No se puede eliminar el coche porque está asociado a lineas de carrito.');
        }
        if ($producto->favoritos_productos->count() > 0) {
            return redirect()->back()->with('error', 'No se puede eliminar el coche porque está asociada a favoritos.');
        }
        $producto->delete();
        $coche->delete();
        return app()->make(ProductosController::class)->callAction('mostrarProductos', []);
    }
}
