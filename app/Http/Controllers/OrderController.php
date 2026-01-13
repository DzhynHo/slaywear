<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Wyświetl wszystkie zamówienia użytkownika
    public function index()
    {
        $user = Auth::user();

        // Pobieramy wszystkie zamówienia wraz z produktami
        $orders = Order::with('items.product')
                        ->where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('orders.index', compact('orders'));
    }

    // Dodaj produkt do koszyka
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $user = Auth::user();

        // Szukamy istniejącego zamówienia w statusie pending lub tworzymy nowe
        $order = Order::firstOrCreate([
            'user_id' => $user->id,
            'status' => 'pending',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Dodajemy produkt do order_items
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $product->price,
        ]);

        return redirect()->back()->with('success', 'Produkt dodany do koszyka!');
    }

    // Wyświetl koszyk (zamówienie pending)
    public function cart()
    {
        $order = Order::with('items.product')
                      ->where('user_id', auth()->id())
                      ->where('status', 'pending')
                      ->first();

        return view('orders.cart', compact('order'));
    }

    // Usuń produkt z koszyka
    public function remove(Product $product)
    {
        $order = Order::where('user_id', auth()->id())
                      ->where('status', 'pending')
                      ->first();

        if (! $order) {
            return redirect()->back()->with('error', 'Koszyk jest pusty.');
        }

        $item = OrderItem::where('order_id', $order->id)
                         ->where('product_id', $product->id)
                         ->first();

        if ($item) {
            $item->delete();
        }

        return redirect()->back()->with('success', 'Produkt usunięty z koszyka.');
    }

    // „Zapłać” za zamówienie
    public function pay()
    {
        $order = Order::where('user_id', auth()->id())
                      ->where('status', 'pending')
                      ->first();

        if ($order) {
            $order->status = 'paid';
            $order->save();
        }

        return redirect()->route('orders.index')->with('success', 'Zapłacono!');
    }

    // Wyświetl wszystkie zamówienia (dla administratora)
    public function all()
    {
        $orders = Order::with('items.product', 'user')
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('orders.all', compact('orders'));
    }

    // Zarządzanie zamówieniami (dla pracownika)
    public function manage()
    {
        $orders = Order::with('items.product', 'user')
                       ->where('status', 'pending')
                       ->orderBy('created_at', 'desc')
                       ->get();

        return view('orders.manage', compact('orders'));
    }

    // Aktualizuj status zamówienia (dla pracownika/admina)
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:pending,processing,paid,shipped,cancelled',
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Status zamówienia zaktualizowany.');
    }
}
