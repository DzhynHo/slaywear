<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = Order::with('items.product')->where('user_id', $user->id)->get();

        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $user = Auth::user();

        // Tworzymy zamówienie lub bierzemy ostatnie "pending"
        $order = Order::firstOrCreate([
            'user_id' => $user->id,
            'status'  => 'pending',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Dodajemy pozycję do zamówienia
        OrderItem::create([
            'order_id'   => $order->id,
            'product_id' => $product->id,
            'quantity'   => $request->quantity,
            'price'      => $product->price,
        ]);

        return redirect()->back()->with('success', 'Produkt dodany do koszyka!');
    }
    public function cart() {
    $order = Order::where('user_id', auth()->id())
                  ->where('status', 'pending')
                  ->with('items.product')
                  ->first();

    return view('orders.cart', compact('order'));
}

public function pay() {
    $order = Order::where('user_id', auth()->id())
                  ->where('status', 'pending')
                  ->first();

    if ($order) {
        $order->status = 'paid';
        $order->save();
    }

    return redirect()->route('cart')->with('success', 'Zapłacono!');
}

}
