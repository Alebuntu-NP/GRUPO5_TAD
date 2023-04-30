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
        <h1>{{ __('messages.usuarios') }}</h1>
    </div>
    <div class="table-responsive">
        <table class="table table-striped rounded-2 bg-white">
            <thead>
                <tr class="table-row text-center align-middle">
                    <th>{{ __('messages.nombre') }}</th>
                    <th>{{ __('messages.apellidos') }}</th>
                    <th>{{ __('messages.correo') }}</th>
                    <th>{{ __('messages.telefono') }}</th>
                </tr>
            </thead>
            @foreach ($usuarios as $usuario)
            <tr class="table-row text-center align-middle">
                <td>{{ $usuario->name}}</td>
                <td>{{ $usuario->surname}}</td>
                <td>{{ $usuario->email}}</td>
                <td>{{ $usuario->phone}}</td>
            </tr>
            @endforeach
        </table>
    </div>
    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $usuarios->links() }}
    </div>
</div>
@endsection