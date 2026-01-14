@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Top carousel --}}
    <div id="topCarousel" class="carousel slide top-carousel mb-4" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img 
                    src="{{ asset('images/karusel/11.png') }}" 
                    class="d-block w-100" 
                    alt="Promocja 1"
                    style="width:auto; max-width:100%; height:auto; display:block; margin:0 auto;"
                >
            </div>
            <div class="carousel-item">
                <img 
                    src="{{ asset('images/karusel/12.png') }}" 
                    class="d-block w-100" 
                    alt="Promocja 2"
                    style="width:auto; max-width:100%; height:auto; display:block; margin:0 auto;"
                >
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#topCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Poprzedni</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#topCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Następny</span>
        </button>
    </div>

    <header class="mb-4">
        <h1>Nasze produkty</h1>
        <p>Przegląd dostępnych produktów w sklepie Slaywear.</p>
    </header>

    @if(auth()->check() && auth()->user()->role && auth()->user()->role->name === 'Administrator')
        <div class="mb-3">
            <a href="{{ route('products.create') }}" class="btn btn-success">Dodaj produkt</a>
        </div>
    @endif

    <div class="products-grid">
        @foreach($products as $product)
            <div class="product-item">
                <article class="product-card" aria-labelledby="product-title-{{ $product->id }}">
                    
                    @if(!empty($product->photo))
                        <img src="{{ asset('images/clothes/' . $product->photo) }}" alt="{{ $product->name }}">
                    @endif

                    <div class="product-info">
                        <h2 id="product-title-{{ $product->id }}" class="h6">{{ $product->name }}</h2>
                        <p class="text-muted small mb-1">{{ Str::limit($product->description, 80) }}</p>
                        <p class="price mb-1">{{ $product->price }} zł</p>

                        <div class="d-flex flex-column gap-2">
                            <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-info">
                                Szczegóły
                            </a>

                            <form method="POST" action="{{ route('orders.store') }}">
                                <x-csrf />
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="d-flex align-items-center justify-content-center">
                                    <label for="quantity-{{ $product->id }}" class="visually-hidden">Ilość</label>
                                    <input 
                                        id="quantity-{{ $product->id }}" 
                                        name="quantity" 
                                        type="number" 
                                        value="1" 
                                        min="1" 
                                        class="form-control form-control-sm me-2" 
                                        style="width:64px;"
                                    >
                                    <button type="submit" class="button-buy">Dodaj</button>
                                </div>
                            </form>
                        </div>

                        @if(auth()->check() && auth()->user()->role && auth()->user()->role->name === 'Administrator')
                            <div class="mt-2 d-flex gap-2">
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-secondary">Edytuj</a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST">
                                    <x-csrf />
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Usuń</button>
                                </form>
                            </div>
                        @endif

                    </div>
                </article>
            </div>
        @endforeach
    </div>

</div>
@endsection
