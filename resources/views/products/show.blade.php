@extends('layouts.app')

@section('content')
<div class="container" role="main">
    <div class="row mt-4">
        <div class="col-lg-6">
            {{-- Zdjęcie produktu --}}
            <div class="product-detail-image mb-4">
                @if(!empty($product->photo))
                    <img src="{{ asset('images/clothes/' . $product->photo) }}" 
                         alt="{{ $product->name }}" 
                         class="img-fluid rounded-3 shadow"
                         style="max-width: 100%; height: auto;">
                @else
                    <div class="bg-light rounded-3 p-5 text-center">
                        <p class="text-muted">Brak zdjęcia</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-6">
            {{-- Informacje o produkcie --}}
            <div class="product-details-box p-4 rounded-3 border shadow-sm" style="background-color: #f9f9f9; border: 2px solid #b71c1c;">
                <h1>{{ $product->name }}</h1>
                
                @if($product->category)
                    <p class="text-muted mb-2">
                        <strong>Kategoria:</strong> {{ $product->category->name }}
                    </p>
                @endif

                <p class="text-muted mb-3">{{ $product->description }}</p>

                <div class="price-box mb-3">
                    <span class="h3" style="color: #d32f2f;">{{ number_format($product->price, 2, ',', ' ') }} zł</span>
                </div>

                @if($product->isInStock())
                    <div class="alert alert-success" role="alert">
                        ✓ Dostępne ({{ $product->stock }} szt.)
                    </div>
                    <form method="POST" action="{{ route('orders.store') }}" class="mb-4">
                        <x-csrf />
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="d-flex align-items-center gap-2">
                            <input name="quantity" type="number" value="1" min="1" 
                                   class="form-control" style="width: 100px;">
                            <button type="submit" class="btn btn-danger" style="background-color: #b71c1c;">
                                🛒 Dodaj do koszyka
                            </button>
                        </div>
                    </form>
                @else
                    <div class="alert alert-warning" role="alert">
                        ⚠ Brak na stanie
                    </div>
                @endif

                {{-- Powrót i akcje admina --}}
                <div class="mt-4 pt-3 border-top">
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">← Powrót do produktów</a>
                    
                    @if(auth()->check() && auth()->user()->hasRole('Administrator'))
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-secondary">Edytuj</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline-block">
                            <x-csrf />
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Na pewno?')">Usuń</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Sekcja Recenzji --}}
    <div class="row mt-5">
        <div class="col-lg-8 offset-lg-2">
            <div class="reviews-section p-4 rounded-3 border shadow-sm" style="background-color: #f9f9f9; border: 2px solid #b71c1c;">
                <h2 class="mb-4">Opinie i Recenzje ({{ $reviews->count() }})</h2>

                {{-- Formularz dodania recenzji --}}
                @if(auth()->check() && auth()->user()->hasRole('Klient'))
                    <div class="add-review-box mb-4 p-4 rounded-3" style="background-color: #ffffff; border: 2px solid #b71c1c;">
                        <h5 class="mb-3">Dodaj swoją opinię</h5>
                        <form method="POST" action="{{ route('reviews.store', $product) }}">
                            <x-csrf />
                            
                            <div class="mb-3">
                                <label for="rating" class="form-label">Ocena *</label>
                                <select name="rating" id="rating" class="form-select" required>
                                    <option value="">Wybierz ocenę...</option>
                                    <option value="5">⭐⭐⭐⭐⭐ Doskonały (5)</option>
                                    <option value="4">⭐⭐⭐⭐ Bardzo dobry (4)</option>
                                    <option value="3">⭐⭐⭐ Dobry (3)</option>
                                    <option value="2">⭐⭐ Słaby (2)</option>
                                    <option value="1">⭐ Bardzo słaby (1)</option>
                                </select>
                                @error('rating')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="comment" class="form-label">Komentarz *</label>
                                <textarea name="comment" id="comment" class="form-control" rows="4" 
                                          placeholder="Podziel się swoją opinią..." required></textarea>
                                @error('comment')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary" style="background-color: #b71c1c; border-color: #b71c1c;">Wyślij opinię</button>
                        </form>
                    </div>
                @endif

                {{-- Wyświetlanie recenzji --}}
                @if($reviews->count() > 0)
                    <div class="reviews-list">
                        @foreach($reviews as $review)
                            <div class="review-item mb-3 p-3 rounded-2" style="background-color: #ffffff; border-left: 4px solid #b71c1c; color: #000;">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <strong style="color: #000;">{{ $review->user->name }}</strong>
                                        <div class="text-warning small">
                                            @for($i = 0; $i < $review->rating; $i++)
                                                ⭐
                                            @endfor
                                        </div>
                                        <small class="text-muted">{{ $review->created_at->format('d.m.Y H:i') }}</small>
                                    </div>

                                    {{-- Usuwanie recenzji (Admin) --}}
                                    @if(auth()->check() && (auth()->user()->hasRole('Administrator') || auth()->id() === $review->user_id))
                                        <form action="{{ route('reviews.destroy', $review) }}" method="POST" style="display:inline-block">
                                            <x-csrf />
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Usunąć recenzję?')">🗑️</button>
                                        </form>
                                    @endif
                                </div>
                                <p class="mb-0" style="color: #000;">{{ $review->comment }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">
                        Brak recenzji. Bądź pierwszy i napisz opinię!
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>

<style>
    .product-details-box {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .product-details-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15) !important;
    }

    .reviews-section {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .reviews-section:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1) !important;
    }

    .review-item {
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .review-item:hover {
        background-color: #f0f0f0 !important;
        transform: translateX(5px);
    }

    .add-review-box {
        transition: box-shadow 0.3s ease;
    }

    .add-review-box:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection
