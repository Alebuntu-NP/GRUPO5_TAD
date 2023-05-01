<?php

namespace App\Http\Controllers;



use App\Mail\DatosCompra;
use App\Models\Carrito_compra;
use App\Models\Linea_carrito;
use App\Models\Compra;
use App\Models\Linea_compra;
use App\Models\Producto;
use App\Rules\Calendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class Carrito_comprasController extends Controller
{

    public function mostrarCarrito()
    {
        $id = Auth::user()->id;
        $mi_carrito = Carrito_compra::findOrFail($id);
        return view('carrito', @compact('mi_carrito'));
    }



    public function aumentarLineaCarrito(Request $request)
    {

        $id = Auth::user()->id;
        $mi_carrito = Carrito_compra::findOrFail($id);
        $linea_carrito = Linea_carrito::findOrFail($request->id);

        $linea_carrito->cantidad +=  1;
        $mi_carrito->precio_total += $linea_carrito->producto->precio;
        $linea_carrito->precio_parcial += $linea_carrito->producto->precio;
        $linea_carrito->save();
        $mi_carrito->save();

        return app()->make(Carrito_comprasController::class)->callAction('mostrarCarrito', []);
    }

    public function disminuirLineaCarrito(Request $request)
    {
        $id = Auth::user()->id;
        $mi_carrito = Carrito_compra::findOrFail($id);
        $linea_carrito = Linea_carrito::findOrFail($request->id);


        $linea_carrito->cantidad -=  1;
        $mi_carrito->precio_total -= $linea_carrito->producto->precio;
        $linea_carrito->precio_parcial -= $linea_carrito->producto->precio;
        $linea_carrito->save();
        $mi_carrito->save();

        if ($linea_carrito->precio_parcial <= 0) {
            $linea_carrito->delete();
        }
        return app()->make(Carrito_comprasController::class)->callAction('mostrarCarrito', []);
    }


    public function addToCarrito(Request $request)
    {        
        if ($request->tipo == "coche") {

            $fechas = Linea_compra::where('fk_producto_id', $request->id)
            ->pluck('fecha_reserva')
            ->unique();
            $inactiveDays = $fechas->toArray();

            $reglas = [
                'cantidad' => 'required|integer|min:1|max:8',
                'fecha' => ['required', new Calendar($inactiveDays)],
            ];

            $mensajes = [
                'cantidad.required' => 'El campo número es obligatorio.',
                'cantidad.integer' => 'El campo número debe ser un número entero.',
                'cantidad.min' => 'El campo número debe ser mayor o igual a 1.',
                'cantidad.max' => 'El campo número debe ser menor o igual a 8.',
                'fecha.required' => 'El campo fecha es obligatorio.',
            ];
            $validaciones = Validator::make($request->all(), $reglas, $mensajes);
            if ($validaciones->fails()) {
                return redirect()->route('verCoche', ['id' => $request->id])->withErrors($validaciones)->withInput();
            }
        } else if ($request->tipo == "accesorio") {

            $reglas = [
                'cantidad' => 'required|integer|min:1|max:8',
            ];

            $mensajes = [
                'cantidad.required' => 'El campo número es obligatorio.',
                'cantidad.integer' => 'El campo número debe ser un número entero.',
                'cantidad.min' => 'El campo número debe ser mayor o igual a 1.',
                'cantidad.max' => 'El campo número debe ser menor o igual a 8.',
            ];
            $validaciones = Validator::make($request->all(), $reglas, $mensajes);
            if ($validaciones->fails()) {
                return redirect()->route('verAccesorio', ['id' => $request->id])->withErrors($validaciones)->withInput();
            }
        }


        $id = Auth::user()->id;
        $producto = Producto::find($request->id);
        $existe_producto_en_carrito = DB::table('carrito_compras')
            ->join('linea_carritos', 'carrito_compras.id', '=', 'linea_carritos.fk_carrito_id')
            ->where('linea_carritos.fk_producto_id', '=', $producto->id)
            ->where('carrito_compras.fk_user', '=', Auth::id())
            ->exists();

        if (!$existe_producto_en_carrito) {
            $mi_carrito = Carrito_compra::find($id);
            $linea_carrito = new Linea_carrito();
            $linea_carrito->fk_producto_id = $producto->id;
            $linea_carrito->fk_carrito_id = $mi_carrito->id;
            $linea_carrito->cantidad = $request->cantidad;
            $linea_carrito->precio_parcial = $request->cantidad * $producto->precio;
            if ($request->tipo == "coche") {
                $linea_carrito->fecha_reserva = $request->fecha;
            }
            $linea_carrito->save();
            $mi_carrito->precio_total = $mi_carrito->precio_total + $linea_carrito->precio_parcial;
            $mi_carrito->save();
        }
        return app()->make(Carrito_comprasController::class)->callAction('mostrarCarrito', []);
    }


    public function comprarCarrito()
    {
        $id = Auth::user()->id;
        $mi_carrito = Carrito_compra::findOrFail($id);
        $compra = new Compra();
        $compra->fk_user = $mi_carrito->fk_user;
        $compra->estado = "Pendiente";
        $compra->precio_total = $mi_carrito->precio_total;
        $compra->fecha = date("Y-m-d");
        $compra->save();
        foreach ($mi_carrito->lineas_de_carrito as $linea_carrito) {
            $linea_compra = new Linea_compra();
            $linea_compra->fk_producto_id = $linea_carrito->fk_producto_id;
            $linea_compra->fk_compra_id =  $compra->id;
            $linea_compra->cantidad = $linea_carrito->cantidad;
            $linea_compra->precio_parcial = $linea_carrito->precio_parcial;
            $linea_compra->created_at = $linea_carrito->created_at;
            $linea_compra->updated_at = $linea_carrito->updated_at;
            $linea_compra->fecha_reserva = $linea_carrito->fecha_reserva;
            $linea_compra->save();
        }

        $mail = new DatosCompra($compra);
        Mail::to($id = Auth::user()->email)->send($mail);

        foreach ($mi_carrito->lineas_de_carrito as $linea) {
            $linea->delete();
        }
        $mi_carrito->precio_total = 0;
        $mi_carrito->save();

        return app()->make(ComprasController::class)->callAction('misCompras', []);
    }
}
