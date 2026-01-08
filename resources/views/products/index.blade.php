@extends('layouts.app')

@section('content')
<h1>Nasze produkty</h1>

<div class="row">
@foreach($products as $product)
    <div class="col-md-4 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <h2 class="h5">{{ $product->name }}</h2>
                <p>{{ $product->description }}</p>
                <p><strong>{{ $product->price }} zł</strong></p>

                <form method="POST" action="/orders">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <label for="qty-{{ $product->id }}" class="form-label">Ilość</label>
                    <input id="qty-{{ $product->id }}" type="number" name="quantity" min="1" class="form-control" required>

                    <button class="btn btn-primary mt-2">Dodaj do koszyka</button>
                </form>
            </div>
        </div>
    </div>
@endforeach
</div>
@endsection
