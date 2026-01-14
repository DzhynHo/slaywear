@extends('layouts.app')

@section('content')
<main class="container">
    <h1>Zarządzanie zamówieniami</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Użytkownik</th>
                <th>Pozycje</th>
                <th>Status</th>
                <th>Akcje</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name ?? '—' }}</td>
                    <td>
                        <ul>
                            @foreach($order->items as $item)
                                <li>{{ $item->product->name ?? '—' }} x {{ $item->quantity }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $order->status }}</td>
                    <td>
                        <form action="{{ route('orders.update', $order) }}" method="POST">
                            <x-csrf />
                            @method('PATCH')

                            <select name="status" class="form-select mb-2">
                                <option value="processing">W trakcie</option>
                                <option value="shipped">Wysłane</option>
                                <option value="paid">Opłacone</option>
                                <option value="cancelled">Anulowane</option>
                            </select>

                            <button class="btn btn-sm btn-primary">Zaktualizuj</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</main>
@endsection
