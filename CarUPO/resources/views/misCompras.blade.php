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
        <h1>{{ __('messages.historialCompras') }}</h1>
    </div>
    @if ( sizeof($compras) < 1 ) <div class="alert alert-info">
        <span>{{ __('messages.noCompras') }}</span>
</div>
@else
<div class="table-responsive">
    <table class="table table-striped rounded-2 bg-white">
        <thead>
            <tr class="table-row  text-center align-middle">
                <th>{{ __('messages.fecha') }}</th>
                <th>{{ __('messages.precioTotal') }}</th>
                <th>{{ __('messages.estado') }}</th>
            </tr>
        </thead>

        @foreach ($compras as $compra)
        <tr class="table-row text-center align-middle">
            <td>{{ $compra->fecha }}</td>
            <td>{{ $compra->precio_total }}</td>
            <td>{{ $compra->estado }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endif
</div>
@endsection