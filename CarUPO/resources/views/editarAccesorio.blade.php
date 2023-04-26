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
<div class="container-lg my-3 col-xs-12 col-md-6 col-lg-4 col-xl-4">
    <div class="justify-content-center d-flex mb-3">
        <h1>{{ __('messages.edAccesorio') }}</h1>
    </div>
    <form action="{{ route('editar.accesorio') }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf {{-- Cláusula para obtener un token de formulario al enviarlo --}}
        <label for="nombre" class="form-label">{{ __('messages.nombre') }}</label>
        <input type="text" required name="nombre" value="{{ $accesorio->nombre }}" placeholder="{{ __('messages.nombre') }}" class="form-control mb-2" autofocus>


        <label for="descripcion" class="form-label">{{ __('messages.descripcion') }}</label>
        <textarea type="text" required name="descripcion" placeholder="{{ __('messages.descripcion') }}" class="form-control mb-2">{{ $accesorio->producto->descripcion }}</textarea>
        <label for="categorias" class="form-label">{{ __('messages.categoria') }}</label>

        <select name="categorias[]" class="form-control mb-2" multiple>
            @foreach (DB::table('categorias')->get() as $categoria)
            @if(DB::table('producto_categorias')->where('fk_producto_id', '=', $accesorio->fk_producto_id)->where('fk_categoria_id', '=', $categoria->id)
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

        <input type="number" required name="precio" value="{{ $accesorio->producto->precio }}" placeholder="{{ __('messages.precio') }}" step="0.01" class="form-control mb-2">
        <div class="justify-content-center d-flex">
            <input type="hidden" name="id" value="{{ $accesorio->id }}">
            <button class="buttonP btn btn-primary btn-block m-3" type="submit">
                {{ __('messages.edAccesorio') }}
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