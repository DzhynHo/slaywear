@extends('layouts.app')

@section('content')
<main class="container" role="main">

    <header class="mb-4">
        <h1>Nasze produkty</h1>
        <p>Przegląd dostępnych produktów w sklepie Slaywear.</p>
    </header>

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

                        <form method="POST" action="/orders" aria-label="Dodaj produkt do koszyka">
                            @csrf

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
                                    class="form-control"
                                    required
                                    aria-required="true"
                                >
                            </div>

                            <button type="submit" class="btn btn-primary mt-auto">
                                Dodaj do koszyka
                            </button>
                        </form>

                    </div>
                </div>
            </article>
        @endforeach
    </section>

</main>
@endsection
