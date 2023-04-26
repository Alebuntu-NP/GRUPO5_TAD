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
        <h1>Mi compra</h1>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-striped rounded-2 bg-white">
        <thead>
            <tr class="table-row  text-center align-middle">
                <th>FECHA</th>
                <th>PRECIO TOTAL</th>
                <th>ESTADO</th>
            </tr>
        </thead>

        <tr class="table-row text-center align-middle">
            <td>{{ $compra->fecha }}</td>
            <td>{{ $compra->precio_total }}</td>
            <td>{{ $compra->estado }}</td>
        </tr>
    </table>
</div>
</div>
@endsection