@extends('plantilla')
@section('contenido')

<div class="container-lg my-3 col-xs-10 col-sm-10 col-md-8 col-lg-8 col-xl-8">
    <div class="justify-content-center d-flex mb-3">
        <h1>{{ __('messages.carrito') }}</h1>
    </div>

    @if ( sizeof( $mi_carrito->lineas_de_carrito) < 1 ) <div class="alert alert-info">
        <span>{{ __('messages.noCarrito') }}</span>
</div>
<form>
    @csrf
    <button class="btn btn-danger btn-block disabled" type="submit">
        {{ __('messages.comprar') }}
    </button>
</form>
@else
<div class="table-responsive">
    <table class="table table-striped rounded-2 bg-white">
        <thead>
            <tr class="table-row  text-center align-middle">
                <th>{{ __('messages.producto') }}</th>
                <th>{{ __('messages.cantidad') }}</th>
                <th>{{ __('messages.precioParcial') }}</th>
                <th>{{ __('messages.acciones') }}</th>
            </tr>
        </thead>
        @foreach ($mi_carrito->lineas_de_carrito as $linea)
        <tr class="table-row text-center align-middle">
            <td>
                <img width="20%" height="20%" src="{{ $linea->producto->foto}}" />
            </td>
            <td>{{ $linea->cantidad}}</td>
            <td>{{ $linea->precio_parcial}}€</td>
            <td>
                <form action="{{ route('masLineaCarrito') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{$linea->id}}">
                    <input type="hidden" name="mas" value="mas">
                    <button class="btn" name="mas" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z" />
                        </svg>
                    </button>
                </form>
                <form action="{{ route('menosLineaCarrito') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{$linea->id}}">
                    <button class="btn" name="menos" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-dash-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1h-7z" />
                        </svg>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
<div class="justify-content-center d-flex mt-5">
    <h3>{{ __('messages.precioTotal') }}: {{ $mi_carrito->precio_total}} €</h3>
</div>
<div class="justify-content-center d-flex mt-3">
    <form action="{{ route('comprarCarrito') }}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{$mi_carrito->id}}">
        <button class="buttonP btn btn-danger btn-block" type="submit">
            {{ __('messages.comprar') }}
        </button>
    </form>
</div>
@endif
@endsection