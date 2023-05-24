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
<div class="container-lg my-3 col-xs-12 col-sm-10 col-md-8 col-lg-8 col-xl-8">

    <div class="justify-content-center d-flex mb-3">
        <h1>{{ $accesorio->nombre }}</h1>
    </div>
    <div class="table-responsive">
        <table class="table table-striped rounded-2 bg-white">
            <tr class="table-row  text-center align-middle">
                <td class="fw-bold">{{ __('messages.nombre') }}</td>
                <td>{{ $accesorio->nombre }}</td>
            </tr>
            <tr class="table-row  text-center align-middle">
                <td class="fw-bold">{{ __('messages.descripcion') }}</td>
                <td>{{ $accesorio->producto->descripcion }}</td>
            </tr>
            <tr class="table-row  text-center align-middle">
                <td class="fw-bold">{{ __('messages.precio') }}</td>
                <td>{{ $accesorio->producto->precio }}</td>
            </tr>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        <form action="{{ route('accesorio.borrar') }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" name="id" value="{{ $accesorio->id }}">
            <button class="btn btn-danger btn-block" type="submit">
                {{ __('messages.elAccesorio') }}
            </button>
        </form>
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
    </div>
    @if (Auth::user()->isAdmin() == false)
        <div class="d-flex justify-content-start mt-5">
            <form action="{{ route('mostrarProductos') }}" method="GET">
                @csrf
                <button class="btn btn-danger btn-block" type="submit">
                    {{ __('messages.atras') }}
                </button>
            </form>
        </div>

        @else
        <div class="d-flex justify-content-start mt-5">
            <form action="{{ route('mostrarAccesorios') }}" method="GET">
                @csrf
                <button class="btn btn-danger btn-block" type="submit">
                    {{ __('messages.atras') }}
                </button>
            </form>
        </div>
        @endif
</div>
@endsection