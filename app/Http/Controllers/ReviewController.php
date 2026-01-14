<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Dodanie recenzji
    public function store(Request $request, Product $product)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:3|max:1000',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return redirect()->route('products.show', $product)->with('success', 'Recenzja dodana!');
    }

    // Usunięcie recenzji (Admin)
    public function destroy(Review $review)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Sprawdzenie, czy użytkownik jest autorem lub adminisztratorem
        if (Auth::id() !== $review->user_id && !Auth::user()->hasRole('Administrator')) {
            return redirect()->back()->with('error', 'Brak uprawnień!');
        }

        $productId = $review->product_id;
        $review->delete();

        return redirect()->route('products.show', $productId)->with('success', 'Recenzja usunięta!');
    }
}
