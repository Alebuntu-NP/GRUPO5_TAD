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
        <h1>{{ $coche->marca }} {{ $coche->modelo }}</h1>
    </div>
    <div class="table-responsive">
        <table class="table table-striped rounded-2 bg-white">
            <tr class="table-row  text-center align-middle">
                <td class="fw-bold">{{ __('messages.marca') }}</td>
                <td>{{ $coche->marca }}</td>
            </tr>
            <tr class="table-row  text-center align-middle">
                <td class="fw-bold">{{ __('messages.modelo') }}</td>
                <td>{{ $coche->modelo }}</td>
            </tr>
            <tr class="table-row  text-center align-middle">
                <td class="fw-bold">{{ __('messages.descripcion') }}</td>
                <td>{{ $coche->producto->descripcion }}</td>
            </tr>
            <tr class="table-row  text-center align-middle">
                <td class="fw-bold">{{ __('messages.color') }}</td>
                <td>{{ $coche->color }}</td>
            </tr>
            <tr class="table-row  text-center align-middle">
                <td class="fw-bold">{{ __('messages.combustible') }}</td>
                <td>{{ $coche->combustible }}</td>
            </tr>
            <tr class="table-row  text-center align-middle">
                <td class="fw-bold">{{ __('messages.cilindrada') }}</td>
                <td>{{ $coche->cilindrada }}</td>
            </tr>
            <tr class="table-row  text-center align-middle">
                <td class="fw-bold">{{ __('messages.potencia') }}</td>
                <td>{{ $coche->potencia }}</td>
            </tr>
            <tr class="table-row  text-center align-middle">
                <td class="fw-bold">{{ __('messages.nPuertas') }}</td>
                <td>{{ $coche->nPuertas }}</td>
            </tr>
            <tr class="table-row  text-center align-middle">
                <td class="fw-bold">{{ __('messages.precio') }}</td>
                <td>{{ $coche->producto->precio }}</td>
            </tr>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        <form action="{{ route('coche.borrar') }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" name="id" value="{{ $coche->id }}">
            <button class="btn btn-danger btn-block" type="submit">
                {{ __('messages.elCoche') }}
            </button>
        </form>
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
    </div>
    <div class="d-flex justify-content-start mt-5">
        <form action="{{ route('mostrarProductos') }}" method="GET">
            @csrf
            <button class="buttonP btn btn-danger btn-block" type="submit">
                {{ __('messages.atras') }}
            </button>
        </form>
    </div>
</div>
@endsection