<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        Product::create($validated);

        return redirect()->route('home');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $product->update($validated);

        return redirect()->route('home');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('home');
    }

    // -------------------------------
    // Dodawanie produktu do koszyka
    // -------------------------------
    public function addToCart(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();

        // Pobierz istniejące zamówienie w statusie pending
        $order = Order::firstOrCreate(
            ['user_id' => $user->id, 'status' => 'pending'],
            ['total_price' => 0]
        );

        // Dodaj pozycję do order_items
        $orderItem = OrderItem::updateOrCreate(
            [
                'order_id' => $order->id,
                'product_id' => $product->id
            ],
            [
                'quantity' => $request->quantity,
                'price' => $product->price
            ]
        );

        // Aktualizacja całkowitej ceny
        $order->total_price = $order->items()->sum(function($item) {
            return $item->price * $item->quantity;
        });
        $order->save();

        return redirect()->route('cart')->with('success', 'Dodano do koszyka!');
    }
}
