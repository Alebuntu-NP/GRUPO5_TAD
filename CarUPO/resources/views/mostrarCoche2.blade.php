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
        <h1>{{ old('marca', $coche->marca) }} {{ old('modelo', $coche->modelo) }}</h1>
    </div>
    <p>
        {{ __('messages.precioHora') }}
    </p>
    <p>
        {{ old('descripcion', $coche->producto->descripcion) }}
    </p>

    <div class="justify-content-center d-flex mb-3">
        <img src="{{ old('foto', $coche->producto->foto)}}" class="card-img-top h-50 w-50" alt="{{ old('marca')}} {{ old('modelo') }} {{ old('color') }}">
    </div>

    <div class="table-responsive">
        <table class="table table-striped rounded-2 bg-white">
            <tr class="table-row  text-center align-middle">
                <td class="fw-bold">{{ __('messages.marca') }}</td>
                <td>{{ old('marca', $coche->marca) }}</td>
            </tr>
            <tr class="table-row  text-center align-middle">
                <td class="fw-bold">{{ __('messages.modelo') }}</td>
                <td>{{ old('modelo', $coche->modelo) }}</td>
            </tr>
            <tr class="table-row  text-center align-middle">
                <td class="fw-bold">{{ __('messages.categorias') }}</td>
                <td>
                    @foreach (DB::table('categorias')->get() as $categoria)
                    @if (DB::table('producto_categorias')->where('fk_producto_id', '=', old('id', $coche->fk_producto_id))->where('fk_categoria_id', '=', $categoria->id)->exists())

                    {{ $categoria->nombre }}

                    @endif
                    @endforeach
                </td>
            </tr>
            <tr class="table-row  text-center align-middle">
                <td class="fw-bold">{{ __('messages.color') }}</td>
                <td>{{ old('color', $coche->color) }}</td>
            </tr>
            <tr class="table-row  text-center align-middle">
                <td class="fw-bold">{{ __('messages.combustible') }}</td>
                <td>{{ old('combustible', $coche->combustible) }}</td>
            </tr>
            <tr class="table-row  text-center align-middle">
                <td class="fw-bold">{{ __('messages.cilindrada') }} (cc)</td>
                <td>{{ old('cilindrada', $coche->cilindrada) }}</td>
            </tr>
            <tr class="table-row  text-center align-middle">
                <td class="fw-bold">{{ __('messages.potencia') }} (cv)</td>
                <td>{{ old('potencia', $coche->potencia) }}</td>
            </tr>
            <tr class="table-row  text-center align-middle">
                <td class="fw-bold">{{ __('messages.nPuertas') }}</td>
                <td>{{ old('nPuertas', $coche->nPuertas) }}</td>
            </tr>
            <tr class="table-row  text-center align-middle">
                <td class="fw-bold">{{ __('messages.precio') }}</td>
                <td>{{ old('precio', $coche->producto->precio) }}</td>
            </tr>
        </table>
    </div>
    @if (Auth::user()->isAdmin() == false)
    <div class="d-flex justify-content-center">
        <form action="{{ route('addToCarrito') }}" method="POST">
            @csrf
            <label>Fecha: </label>
            <input type="date" name="fecha"></input>
            @if ($errors->has('fecha'))
            <div class=" alert alert-danger">
                {{ $errors->first('fecha') }}
            </div>
            @endif

            <label>{{ __('messages.cantidad') }}: </label>
            <input type="number" value="{{ old('cantidad', 1) }}" name="cantidad"></input>
            @if ($errors->has('cantidad'))
            <div class=" alert alert-danger">
                {{ $errors->first('cantidad') }}
            </div>
            @endif

            <button class="buttonP btn btn-danger btn-block" type="submit">
                {{ __('messages.addCarrito') }}
            </button>
        </form>
    </div>
    @if(DB::table('favoritos')
    ->join('favorito_productos', 'favoritos.id', '=', 'favorito_productos.fk_favorito_id')
    ->where('favorito_productos.fk_producto_id', '=', old('id', $coche->fk_producto_id) )
    ->where('favoritos.fk_user', '=', Auth::id())
    ->exists())
    <div class="d-flex justify-content-center mt-3">
        <form action="{{ route('eliminarFavorito') }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" name="idf" value="{{  old('id', $coche->fk_producto_id) }}">
            <button class="buttonP btn btn-danger btn-block" type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="yellow" class="bi bi-star-fill" viewBox="0 0 16 16">
                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                </svg>
            </button>
        </form>
    </div>
    @else
    <div class="d-flex justify-content-center mt-3">
        <form action="{{ route('addToFavoritos') }}" method="POST">
            @csrf
            <input type="hidden" name="idf" value="{{  old('id', $coche->fk_producto_id) }}">
            <button class="buttonP btn btn-danger btn-block" type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                </svg>
            </button>
        </form>
    </div>
    @endif
    @endif

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