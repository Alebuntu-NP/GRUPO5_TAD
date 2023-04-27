@extends('plantilla')
@section('contenido')
@guest
{{ app()->setLocale('es') }}

@else
@if (Auth::user()->language == 'es')
{{ app()->setLocale('es') }}
@else
{{ app()->setLocale('en') }}
@endif
@endguest
<div class="container-lg my-3 col-xs-10 col-md-8 col-lg-8 col-xl-8">
    <div class="justify-content-center d-flex mb-3">
        <h1>Detalles de la compra {{ $compra->id }}</h1>
    </div>
    <div class="table-responsive">
        <table class="table table-striped rounded-2 bg-white">
            <tr class="table-row  text-center align-middle">
                <td>FECHA</td>
                <td>{{ $compra->fecha }}</td>
            </tr>
            <tr class="table-row  text-center align-middle">
                <td>PRECIO TOTAL</td>
                <td>{{ $compra->precio_total }}</td>
            </tr>
            <tr class="table-row  text-center align-middle">
                <td>ESTADO</td>
                <td>{{ $compra->estado }}</td>
            </tr>
        </table>

        <div class="justify-content-center d-flex mb-3 mt-5">
            <h3>Productos</h3>
        </div>
        <table class="table table-striped rounded-2 bg-white">
            <thead>
                <tr class="table-row  text-center align-middle">
                    <th>{{ __('messages.producto') }}</th>
                    <th>{{ __('messages.cantidad') }}</th>
                    <th>{{ __('messages.precioParcial') }}</th>
                </tr>
            </thead>
            @foreach ($compra->lineas_de_compra as $linea)
            <tr class="table-row text-center align-middle">
                <td>
                    <img width="20%" height="20%" src="{{ $linea->producto->foto}}" />
                </td>
                <td>{{ $linea->cantidad}}</td>
                <td>{{ $linea->precio_parcial}}€</td>
            </tr>
            @endforeach
        </table>
    </div>
</div>

</div>
@endsection