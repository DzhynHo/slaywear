@extends('layouts.app')

@section('content')
<h1 class="mb-4">Nasze produkty</h1>

<div class="row">
@foreach($products as $product)
    <div class="col-md-4 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">{{ $product->name }}</h2>
                <p>{{ $product->description }}</p>
                <p><strong>{{ $product->price }} zł</strong></p>

                @auth
                    <form method="POST" action="{{ route('orders.store') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <label for="qty-{{ $product->id }}" class="form-label">Ilość</label>
                        <input id="qty-{{ $product->id }}" type="number" name="quantity" min="1" class="form-control mb-2" required>
                        <button class="btn btn-primary">Dodaj do koszyka</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-secondary">Zaloguj się, aby kupić</a>
                @endauth
            </div>
        </div>
    </div>
@endforeach
</div>
@endsection
