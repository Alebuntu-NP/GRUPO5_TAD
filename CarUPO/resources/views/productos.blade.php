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

<div class="container-lg my-3 col-10">
    <div class="justify-content-center d-flex mb-3">
        <h1>{{ __('messages.productos') }}</h1>
    </div>

    @if(isset($success))
    <div class="alert alert-success">
        {{ $success }}
    </div>
    @endif
    @if ($productos->isEmpty())
    <div class="alert alert-info">
        <span>{{ __('messages.noProductos') }}</span>
    </div>
    @else

    <div class="justify-content-center d-flex m-4 ">
        <div>
            <h4>{{ __('messages.filtradoCategorias') }}</h4>
            <form action="{{ route('filtrarProductos') }}" method="GET">
                <select class="form-select" name="categoria" aria-label="Default select example">
                    <option value="0">{{ __('messages.noFiltro') }}</option>
                    @foreach (DB::table('categorias')->get() as $categoria)
                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
                <div class="justify-content-center d-flex">
                    <button class="buttonP btn btn-primary btn-block mt-2" type="submit">
                        {{ __('messages.filtrar') }}
                    </button>
                </div>
            </form>
        </div>
    </div>    
    
    <div class="row row-cols-1 row-cols-xs-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
        @foreach ($productos as $producto)
        @if ($producto->coche != null)
        <div class="col">
            <div class="card h-100">
                <img src="{{$producto->foto}}" class="card-img-top" alt="{{ $producto->coche->marca }} {{ $producto->coche->modelo }} {{ $producto->coche->color }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $producto->coche->marca }} {{ $producto->coche->modelo }} {{ $producto->coche->cilindrada }}</h5>
                    <p class="card-text">{{ $producto->coche->producto->descripcion }}</p>
                    <p class="card-text"><b>Precio:</b> &nbsp;{{ $producto->precio }} €/hora</p>
                </div>
                <div class="card-footer justify-content-center d-flex">
                    <form action="{{ route('verCoche') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $producto->coche->id }}">
                        <button class="buttonP btn btn-primary" type="submit">
                            {{ __('messages.verProd') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif
        @if ($producto->accesorio != null)
        <div class="col">
            <div class="card h-100">
                <img src="{{$producto->foto}}" class="card-img-top" alt="{{ $producto->accesorio->nombre }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $producto->accesorio->nombre }}</h5>
                    <p class="card-text">{{ $producto->descripcion }}</p>
                    <p class="card-text d-flex align-items-end"><b>Precio:</b> &nbsp;{{ $producto->precio }} €</p>
                </div>
                <div class="card-footer justify-content-center d-flex">
                    <form action="{{ route('verAccesorio') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $producto->accesorio->id }}">
                        <button class="buttonP btn btn-primary" type="submit">
                            {{ __('messages.verProd') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>
    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-3">
        {{ $productos->links() }}
    </div>
    @endif

</div>
@endsection