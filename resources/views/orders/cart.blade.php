@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Twój koszyk</h1>

    @if(!$order || $order->items->isEmpty())
        <p>Twój koszyk jest pusty.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Produkt</th>
                    <th>Ilość</th>
                    <th>Cena</th>
                    <th>Łącznie</th>
                    <th>Akcja</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->price }} zł</td>
                        <td>{{ $item->quantity * $item->price }} zł</td>
                        <td>
                            <form action="{{ route('cart.remove', $item->product->id) }}" method="POST">
                                <x-csrf />
                                <button type="submit" class="btn btn-danger btn-sm">Usuń</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p><strong>Łączna kwota: </strong> {{ $order->items->sum(fn($i) => $i->quantity * $i->price) }} zł</p>

        <form action="{{ route('payments.pay') }}" method="POST">
            <x-csrf />
            <button type="submit" class="btn btn-success">Zapłać</button>
        </form>
    @endif
</div>
@endsection
