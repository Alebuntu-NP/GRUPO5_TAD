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
        <h1>Cambio de contraseña</h1>
    </div>
    <form action="{{ route('updatePass') }}" method="POST">
        @method('PUT')
        @csrf
        <table class="table m-3 rounded-2 bg-white">
            <tr class="table-row  text-center align-middle">
                <td class="fw-bold">{{ __('messages.dni') }}</td>
                <td>{{ Auth::user()->dni }}</td>
            </tr>
            <tr class="table-row  text-center align-middle">
                <td class="fw-bold">{{ __('messages.nombre') }}</td>
                <td>{{ Auth::user()->name }}</td>
            </tr>
            <tr class="table-row  text-center align-middle">
                <td class="fw-bold">{{ __('messages.apellidos') }}</td>
                <td>{{ Auth::user()->surname }}</td>
            </tr>
            <tr class="table-row  text-center align-middle">
                <td class="fw-bold">{{ __('messages.correo') }}</td>
                <td><input type="text" name="email" value="{{ Auth::user()->email }}"></td>
            </tr>
            <tr class="table-row  text-center align-middle">
                <td class="fw-bold">{{ __('messages.telefono') }}</td>
                <td>
                    <input type="text" name="phone" value="{{ Auth::user()->phone }}">
                    <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                </td>
            </tr>
            <tr class="table-row  text-center align-middle">
                <td class="fw-bold">{{ __('messages.idioma') }}</td>
                <td class="justify-content-center d-flex">
                    <select class="form-select h-50 w-50" name="language" aria-label="Default select example">
                        @if (Auth::user()->language == "es")
                        <option selected value="es">{{ __('messages.es') }}</option>
                        <option value="en">{{ __('messages.en') }}</option>
                        @else
                        <option value="es">{{ __('messages.es') }}</option>
                        <option selected value="Ingles">{{ __('messages.en') }}</option>
                        @endif
                    </select>
                </td>
            </tr>
        </table>
        <div class="justify-content-center d-flex">
            <button class="buttonP btn btn-primary btn-block m-3" type="submit">
                {{ __('messages.acUser') }}
            </button>
        </div>
    </form>

    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        Cambiar contraseña
    </button>
</div>
@endsection



<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Cambio de contrase</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Understood</button>
            </div>
        </div>
    </div>
</div>