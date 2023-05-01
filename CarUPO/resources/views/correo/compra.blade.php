<h1>{{ __('messages.datosCompra') }}{{$compra->id}}</h1>

<h2>{{ __('messages.fecha') }}: {{$compra->fecha}}</h2>
<table class="table m-3 rounded-2 bg-white">
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

        <td>{{ $linea->precio_parcial * $linea->cantidad}}€</td>
    </tr>
</table>

<h1>{{ __('messages.precioTotal') }}: {{ $compra->precio_total}}€</h1>
@endforeach