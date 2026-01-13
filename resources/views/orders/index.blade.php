@extends('layouts.app')

@section('content')
<main class="container">
    <h1>Moje zamówienia</h1>

    @if($orders->isEmpty())
        <p>Nie masz jeszcze żadnych zamówień.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID zamówienia</th>
                    <th>Produkty</th>
                    <th>Status</th>
                    <th>Data</th>
                    <th>Łączna kwota</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>
                            <ul>
                                @foreach($order->items as $item)
                                    <li>{{ $item->product->name }} x {{ $item->quantity }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                        <td>{{ $order->items->sum(fn($i) => $i->quantity * $i->price) }} zł</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</main>
@endsection
