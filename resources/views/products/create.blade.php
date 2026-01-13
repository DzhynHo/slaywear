@extends('layouts.app')

@section('content')
<main class="container">
    <h1>Dodaj produkt</h1>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nazwa</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Cena</label>
            <input type="number" name="price" step="0.01" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Ilość w magazynie</label>
            <input type="number" name="stock" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kategoria</label>
            <select name="category_id" class="form-control" required>
                @foreach(App\Models\Category::all() as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Opis</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <button class="btn btn-primary">Zapisz</button>
    </form>
</main>
@endsection
