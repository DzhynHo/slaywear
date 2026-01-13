<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function add(Product $product, Request $request)
    {
        $quantity = $request->input('quantity', 1);

        $cart = session()->get('cart', []);

        if(isset($cart[$product->id])){
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "price" => $product->price,
                "quantity" => $quantity
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Produkt dodany do koszyka!');
    }

    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$product->id])){
            unset($cart[$product->id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Produkt usunięty z koszyka!');
    }
}
