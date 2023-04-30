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
<div class="container-lg my-3 col-xs-12 col-sm-10 col-md-6 col-lg-4 col-xl-4">
    <div class="justify-content-center d-flex mb-3">
        <h1>{{ __('messages.editar') }} {{ old('marca', $coche->marca) }} {{ old('modelo', $coche->modelo) }}</h1>
    </div>
    <form action="{{ route('editar.coche') }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf {{-- Cláusula para obtener un token de formulario al enviarlo --}}
        <label for="marca" class="form-label">{{ __('messages.marca') }}</label>
        <input type="text" required name="marca" value="{{ old('marca', $coche->marca) }}" placeholder="{{ __('messages.marca') }}" class="form-control mb-2" autofocus>
        @if ($errors->has('marca'))
        <div class="alert alert-danger mt-2">
            {{ $errors->first('marca') }}
        </div>
        @endif
        <label for="modelo" class="form-label">{{ __('messages.modelo') }}</label>
        <input type="text" required name="modelo" value="{{ old('modelo', $coche->modelo) }}" placeholder="{{ __('messages.modelo') }}" value="" class="form-control mb-2">
        @if ($errors->has('modelo'))
        <div class="alert alert-danger mt-2">
            {{ $errors->first('modelo') }}
        </div>
        @endif
        <label for="descripcion" class="form-label">{{ __('messages.descripcion') }}</label>
        <textarea type="text" required name="descripcion" placeholder="{{ __('messages.descripcion') }}" class="form-control mb-2">{{ old('descripcion', $coche->producto->descripcion) }}</textarea>
        @if ($errors->has('descripcion'))
        <div class="alert alert-danger mt-2">
            {{ $errors->first('descripcion') }}
        </div>
        @endif
        <label for="color" class="form-label">{{ __('messages.color') }}</label>
        <input type="text" required name="color" value="{{ old('color', $coche->color) }}" placeholder="{{ __('messages.color') }}" class="form-control mb-2">
        @if ($errors->has('color'))
        <div class="alert alert-danger mt-2">
            {{ $errors->first('color') }}
        </div>
        @endif
        <label for="combustible" class="form-label">{{ __('messages.combustible') }}</label>
        <input type="text" required name="combustible" value="{{ old('combustible', $coche->combustible) }}" placeholder="{{ __('messages.combustible') }}" class="form-control mb-2">
        @if ($errors->has('combustible'))
        <div class="alert alert-danger mt-2">
            {{ $errors->first('combustible') }}
        </div>
        @endif
        <label for="cilindrada" class="form-label">{{ __('messages.cilindrada') }}</label>
        <input type="number" required name="cilindrada" value="{{ old('cilindrada', $coche->cilindrada) }}" placeholder="{{ __('messages.cilindrada') }}" step="0.01" class="form-control mb-2">
        @if ($errors->has('cilindrada'))
        <div class="alert alert-danger mt-2">
            {{ $errors->first('cilindrada') }}
        </div>
        @endif
        <label for="potencia" class="form-label">{{ __('messages.potencia') }}</label>
        <input type="number" required name="potencia" value="{{ old('potencia', $coche->potencia) }}" placeholder="{{ __('messages.potencia') }}" step="0.01" class="form-control mb-2">
        @if ($errors->has('potencia'))
        <div class="alert alert-danger mt-2">
            {{ $errors->first('potencia') }}
        </div>
        @endif
        <label for="nPuertas" class="form-label">{{ __('messages.nPuertas') }}</label>
        <input type="number" required name="nPuertas" value="{{ old('nPuertas', $coche->nPuertas) }}" placeholder="{{ __('messages.nPuertas') }}" step="1" class="form-control mb-2">
        @if ($errors->has('nPuertas'))
        <div class="alert alert-danger mt-2">
            {{ $errors->first('nPuertas') }}
        </div>
        @endif
        <label for="categorias" class="form-label">{{ __('messages.categorias') }}</label>
        <div class="containerP">
            @foreach (DB::table('categorias')->get() as $categoria)
            @if(DB::table('producto_categorias')->where('fk_producto_id', '=', $coche->fk_producto_id)->where('fk_categoria_id', '=', $categoria->id)
            ->exists())
            <div class="form-check">
                <input class="form-check-input" name="categorias[]" type="checkbox" value="{{ $categoria->id }}" id="flexCheckChecked" checked>
                <label class="form-check-label" for="flexCheckChecked">
                    {{ $categoria->nombre }}
                </label>
            </div>
            @else
            <div class="form-check">
                <input class="form-check-input" name="categorias[]" type="checkbox" value="{{ $categoria->id }}" id="flexCheck">
                <label class="form-check-label" for="flexCheckDefault">
                    {{ $categoria->nombre }}
                </label>
            </div>
            @endif
            @endforeach
        </div>
        <label for="foto" class="form-label">{{ __('messages.foto') }}</label>
        <input type="file" name="foto" class="form-control mb-2">
        @if ($errors->has('foto'))
        <div class="alert alert-danger mt-2">
            {{ $errors->first('foto') }}
        </div>
        @endif
        <label for="precio" class="form-label">{{ __('messages.precio') }}</label>
        <input type="number" required name="precio" value="{{ old('precio', $coche->producto->precio) }}" placeholder="{{ __('messages.precio') }}" step="0.01" class="form-control mb-2">
        @if ($errors->has('precio'))
        <div class="alert alert-danger mt-2">
            {{ $errors->first('precio') }}
        </div>
        @endif


        <div class="justify-content-center d-flex">
            <input type="hidden" name="id" value="{{ old('id', $coche->id) }}">
            <input type="hidden" name="idp" value="{{ old('idp', $coche->producto->id) }}">
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

    @endsection