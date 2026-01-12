@extends('layouts.app')

@section('content')
<h1>Twój koszyk</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($order && $order->items->count())
    <table class="table">
        <thead>
            <tr>
                <th>Produkt</th>
                <th>Ilość</th>
                <th>Cena</th>
                <th>Razem</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->product->price }} zł</td>
                <td>{{ $item->product->price * $item->quantity }} zł</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3"><strong>Łącznie:</strong></td>
                <td><strong>{{ $order->items->sum(fn($i)=>$i->product->price * $i->quantity) }} zł</strong></td>
            </tr>
        </tbody>
    </table>

    <form method="POST" action="{{ route('cart.pay') }}">
        @csrf
        <button class="btn btn-success">Zapłać</button>
    </form>
@else
    <p>Twój koszyk jest pusty.</p>
@endif
@endsection
