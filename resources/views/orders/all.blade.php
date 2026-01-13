@extends('layouts.app')

@section('content')
<main class="container">
    <h1>Wszystkie zamówienia</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Użytkownik</th>
                <th>Status</th>
                <th>Łącznie</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name ?? '—' }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->items->sum(fn($i) => $i->quantity * $i->price) }} zł</td>
                    <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</main>
@endsection
