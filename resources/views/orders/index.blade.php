@extends('layouts.app')

@section('content')
<h1>Twój koszyk</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($orders->isEmpty())
    <p>Twój koszyk jest pusty.</p>
@else
    @foreach($orders as $order)
        <h2>Zamówienie #{{ $order->id }} ({{ $order->status }})</h2>
        <ul>
            @foreach($order->items as $item)
                <li>{{ $item->product->name }} - {{ $item->quantity }} x {{ $item->price }} zł</li>
            @endforeach
        </ul>
    @endforeach
@endif
@endsection
