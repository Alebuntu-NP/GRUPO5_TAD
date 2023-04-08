@extends('plantilla')
@section('titulo', 'INICIO')
@section('contenido')

@if ($mi_carrito == '[]')
<div class="alert alert-info">
    <span>No hay nada en el carrito</span>
</div>
<form>
    @csrf
    <button class="btn btn-danger btn-block disabled" type="submit">
        Comprar
    </button>
</form>
@else
<table class="table m-3 rounded-2 bg-white">
    <thead>
        <tr class="table-row  text-center align-middle">


            <th>PRODUCTO</th>
            <th>CANTIDAD</th>
            <th>PRECIO PARCIAL</th>
            <th>Editar</th>
        </tr>
    </thead>

    @foreach ($mi_carrito->lineas_de_carrito as $linea)
    <tr class="table-row text-center align-middle">
        <td>
            <img width="20%" height="20%" src="{{ $linea->producto->foto}}" />
        </td>
        <td>{{ $linea->cantidad}}</td>

        <td>{{ $mi_carrito->precio_total}}€</td>
        <td>
            <form action="{{ route('eliminarLineaCarrito') }}" method="POST">
                @method('DELETE')
                @csrf
                <input type="hidden" name="id" value="{{$linea->id}}">
                <button class="btn btn-danger btn-block" type="submit">
                    Eliminar
                </button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
<form action="{{ route('comprarCarrito') }}" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{}}">
    <button class="btn btn-danger btn-block" type="submit">
        Comprar
    </button>
</form>
@endif
@endsection