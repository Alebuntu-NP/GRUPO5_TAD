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
        <h1>{{ __('messages.detallesCompra') }} {{ $compra->id }}</h1>
    </div>
    <div class="table-responsive">
        <table class="table table-striped rounded-2 bg-white">
            <tr class="table-row  text-center align-middle">
                <td>{{ __('messages.fecha') }}</td>
                <td>{{ $compra->fecha }}</td>
            </tr>
            <tr class="table-row  text-center align-middle">
                <td>{{ __('messages.precioTotal') }}</td>
                <td>{{ $compra->precio_total }}</td>
            </tr>
            <tr class="table-row  text-center align-middle">
                <td>{{ __('messages.estado') }}</td>
                <td>{{ $compra->estado }}</td>
            </tr>
        </table>

        <div class="justify-content-center d-flex mb-3 mt-5">
            <h3>{{ __('messages.productos') }}</h3>
        </div>
        <table class="table table-striped rounded-2 bg-white">
            <thead>
                <tr class="table-row  text-center align-middle">
                    <th>{{ __('messages.producto') }}</th>
                    <th>{{ __('messages.nombre') }}</th>
                    <th>{{ __('messages.cantidad') }}</th>
                    <th>{{ __('messages.precioParcial') }}</th>
                </tr>
            </thead>
            @foreach ($compra->lineas_de_compra as $linea)
            <tr class="table-row text-center align-middle">
                <td>
                    <img width="20%" height="20%" src="{{ $linea->producto->foto}}" />
                </td>
                <td>
                    @if ($linea->producto->coche != null)
                    {{ $linea->producto->coche->marca}} {{ $linea->producto->coche->modelo}}
                    @elseif ($linea->producto->accesorio != null)
                    {{ $linea->producto->accesorio->nombre}}
                    @endif
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