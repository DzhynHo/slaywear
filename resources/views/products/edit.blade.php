@extends('layouts.app')

@section('content')
<main class="container">
    <h1>Edytuj produkt</h1>

    <form action="{{ route('products.update', $product) }}" method="POST">
        <x-csrf />
        @method('PATCH')

        <div class="mb-3">
            <label class="form-label">Nazwa</label>
            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Cena</label>
            <input type="number" name="price" step="0.01" class="form-control" value="{{ $product->price }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Ilość w magazynie</label>
            <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kategoria</label>
            <select name="category_id" class="form-control" required>
                @foreach(App\Models\Category::all() as $cat)
                    <option value="{{ $cat->id }}" @if($product->category_id == $cat->id) selected @endif>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Opis</label>
            <textarea name="description" class="form-control">{{ $product->description }}</textarea>
        </div>

        <button class="btn btn-primary">Zapisz</button>
    </form>

    <form action="{{ route('products.destroy', $product) }}" method="POST" class="mt-3">
        <x-csrf />
        @method('DELETE')
        <button class="btn btn-danger">Usuń produkt</button>
    </form>
</main>
@endsection
