@extends('layouts.app')

@section('content')
<main class="container" role="main">

    <header class="mb-4">
        <h1>Nasze produkty</h1>
        <p>Przegląd dostępnych produktów w sklepie Slaywear.</p>
    </header>

    @if(auth()->check() && auth()->user()->role && auth()->user()->role->name === 'Administrator')
        <div class="mb-3">
            <a href="{{ route('products.create') }}" class="btn btn-success">Dodaj produkt</a>
        </div>
    @endif

    <section class="row" aria-label="Lista produktów">
        @foreach($products as $product)
            <article class="col-md-4 mb-4">
                <div class="card h-100" role="article" aria-labelledby="product-title-{{ $product->id }}">
                    <div class="card-body d-flex flex-column">

                        <h2 id="product-title-{{ $product->id }}" class="h5">
                            {{ $product->name }}
                        </h2>

                        <p>
                            <strong>Opis:</strong><br>
                            {{ $product->description }}
                        </p>

                        <p>
                            <strong>Cena:</strong>
                            {{ $product->price }} zł
                        </p>

                        <p>
                            <strong>Dostępność:</strong>
                            {{ $product->stock }} szt.
                        </p>

                        <!-- Formularz dodawania do koszyka -->
                        <form method="POST" action="{{ route('orders.store') }}" aria-label="Dodaj produkt do koszyka">
                            @csrf

                            <!-- Ukryte pole z ID produktu -->
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <div class="mb-2">
                                <label for="quantity-{{ $product->id }}" class="form-label">
                                    Ilość
                                </label>

                                <input
                                    id="quantity-{{ $product->id }}"
                                    type="number"
                                    name="quantity"
                                    min="1"
                                    value="1"
                                    class="form-control"
                                    required
                                    aria-required="true"
                                >
                            </div>

                            <button type="submit" class="btn btn-primary mt-auto">
                                Dodaj do koszyka
                            </button>
                        </form>

                        @if(auth()->check() && auth()->user()->role && auth()->user()->role->name === 'Administrator')
                            <div class="mt-2">
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-secondary">Edytuj</a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Usuń</button>
                                </form>
                            </div>
                        @endif

                    </div>
                </div>
            </article>
        @endforeach
    </section>

</main>
@endsection
