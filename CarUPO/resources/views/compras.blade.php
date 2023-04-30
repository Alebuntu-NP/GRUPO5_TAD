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
        <h1>{{ __('messages.compras') }}</h1>
    </div>
    @if ( sizeof($compras) < 1 ) <div class="alert alert-info">
        <span>{{ __('messages.noCompras') }}</span>
</div>
@else
<div class="table-responsive">
    <table class="table table-striped rounded-2 bg-white">
        <thead>
            <tr class="table-row  text-center align-middle">
                <th>{{ __('messages.usuario') }}</th>
                <th>{{ __('messages.fecha') }}</th>
                <th>{{ __('messages.precioTotal') }}</th>
                <th>{{ __('messages.estado') }}</th>
                <th>{{ __('messages.cambiarEstado') }}</th>
            </tr>
        </thead>

        @foreach ($compras as $compra)
        <tr class="table-row text-center align-middle">
            <td>{{ $compra->user->name}} {{ $compra->user->surname}}</td>
            <td>{{ $compra->fecha }}</td>
            <td>{{ $compra->precio_total }}</td>
            <td>{{ $compra->estado }}</td>
            <td>
                <form action="{{ route('actualizarEstado') }}" method="POST">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="id" value="{{ $compra->id }}">
                    <button class="buttonP btn btn-primary btn-block" type="submit">
                        {{ __('messages.actualizar') }}
                    </button>
                </form>
            <td>
            <td>
                <form action="{{ route('mostrarCompra') }}" method="GET">
                    @csrf
                    <input type="hidden" name="id" value="{{ $compra->id }}">
                    <button class="btn btn-success btn-block" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                        </svg>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endif
{{-- Pagination --}}
<div class="d-flex justify-content-center mt-3">
    {{ $compras->links() }}
</div>
</div>
@endsection