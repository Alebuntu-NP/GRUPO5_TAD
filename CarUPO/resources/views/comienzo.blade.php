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
        <h1>CarUPO</h1>
    </div>

    <div>
        <p>
            {{ __('messages.parrafo1') }}
        </p>
        <p>
            {{ __('messages.parrafo2') }}
        </p>
        <p>
            {{ __('messages.parrafo3') }}
        </p>
    </div>

    <div id="carouselIndicators" class="carousel slide pt-3" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
            <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
            <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="5" aria-label="Slide 6"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('carrusel/c1.png') }}" class="d-block w-100" alt="Coche">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('carrusel/c2.png') }}" class="d-block w-100" alt="Coche">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('carrusel/c3.png') }}" class="d-block w-100" alt="Coche">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('carrusel/c4.png') }}" class="d-block w-100" alt="Coche">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('carrusel/c5.png') }}" class="d-block w-100" alt="Coche">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('carrusel/c6.png') }}" class="d-block w-100" alt="Coche">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">{{ __('messages.anterior') }}</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">{{ __('messages.siguiente') }}</span>
        </button>
    </div>
</div>
@endsection