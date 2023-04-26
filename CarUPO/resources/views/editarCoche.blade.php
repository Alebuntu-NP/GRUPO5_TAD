@extends('plantilla')
@section('titulo','INICIO')
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
<div class="container-lg my-3 col-xs-12 col-sm-10 col-md-6 col-lg-4 col-xl-4">
    <div class="justify-content-center d-flex mb-3">
        <h1>{{ __('messages.editar') }} {{ $coche->marca }} {{ $coche->modelo }}</h1>
    </div>
    <form action="{{ route('editar.coche') }}" method="POST" enctype="multipart/form-data">
        @csrf {{-- Cláusula para obtener un token de formulario al enviarlo --}}
        <label for="marca" class="form-label">{{ __('messages.marca') }}</label>
        <input type="text" required name="marca" value="{{ $coche->marca }}" placeholder="{{ __('messages.marca') }}" class="form-control mb-2" autofocus>

        <label for="modelo" class="form-label">{{ __('messages.modelo') }}</label>
        <input type="text" required name="modelo" value="{{ $coche->modelo }}" placeholder="{{ __('messages.modelo') }}" value="" class="form-control mb-2">

        <label for="descripcion" class="form-label">{{ __('messages.descripcion') }}</label>
        <textarea type="text" required name="descripcion" placeholder="{{ __('messages.descripcion') }}" class="form-control mb-2">{{ $coche->producto->descripcion }}</textarea>

        <label for="color" class="form-label">{{ __('messages.color') }}</label>
        <input type="text" required name="color" value="{{ $coche->color }}" placeholder="{{ __('messages.color') }}" class="form-control mb-2">

        <label for="combustible" class="form-label">{{ __('messages.combustible') }}</label>
        <input type="text" required name="combustible" value="{{ $coche->combustible }}" placeholder="{{ __('messages.combustible') }}" class="form-control mb-2">

        <label for="cilindrada" class="form-label">{{ __('messages.cilindrada') }}</label>
        <input type="number" required name="cilindrada" value="{{ $coche->cilindrada }}" placeholder="{{ __('messages.cilindrada') }}" step="0.01" class="form-control mb-2">

        <label for="potencia" class="form-label">{{ __('messages.potencia') }}</label>
        <input type="number" required name="potencia" value="{{ $coche->potencia }}" placeholder="{{ __('messages.potencia') }}" step="0.01" class="form-control mb-2">

        <label for="nPuertas" class="form-label">{{ __('messages.nPuertas') }}</label>
        <input type="number" required name="nPuertas" value="{{ $coche->nPuertas }}" placeholder="{{ __('messages.nPuertas') }}" step="1" class="form-control mb-2">


        <label for="categorias" class="form-label">{{ __('messages.categoria') }}</label>

        <select name="categorias[]" class="form-control mb-2" multiple>
            @foreach (DB::table('categorias')->get() as $categoria)
            @if(DB::table('producto_categorias')->where('fk_producto_id', '=', $coche->fk_producto_id)->where('fk_categoria_id', '=', $categoria->id)
            ->exists()){
            <option value="{{ $categoria->id }}" class="form-control mb-2" selected>{{ $categoria->nombre }}</option>
            }
            @else
            <option value="{{ $categoria->id }}" class="form-control mb-2">{{ $categoria->nombre }}</option>
            @endif
            @endforeach
        </select>
        <label for="foto" class="form-label">{{ __('messages.foto') }}</label>

        <input type="file" name="foto" class="form-control mb-2">

        <label for="precio" class="form-label">{{ __('messages.precio') }}</label>
        <input type="number" required name="precio" value="{{ $coche->producto->precio }}" placeholder="{{ __('messages.precio') }}" step="0.01" class="form-control mb-2">

        <div class="justify-content-center d-flex">
            <input type="hidden" name="id" value="{{ $coche->id }}">
            <button class="buttonP btn btn-primary btn-block m-3" type="submit">
                {{ __('messages.editar') }}
            </button>
        </div>
    </form>
    <div class="d-flex justify-content-start mt-5">
        <form action="{{ route('mostrarProductos') }}" method="GET">
            @csrf
            <button class="btn btn-danger btn-block" type="submit">
                {{ __('messages.atras') }}
            </button>
        </form>
    </div>
</div>

@endsection