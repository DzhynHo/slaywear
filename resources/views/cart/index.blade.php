@extends('layouts.app')

@section('content')
<h1>Twój koszyk</h1>

@if(session('cart') && count(session('cart')) > 0)
    <table class="table">
        <thead>
            <tr>
                <th>Produkt</th>
                <th>Cena</th>
                <th>Ilość</th>
                <th>Akcja</th>
            </tr>
        </thead>
        <tbody>
            @foreach(session('cart') as $id => $product)
                <tr>
                    <td>{{ $product['name'] }}</td>
                    <td>{{ $product['price'] }} zł</td>
                    <td>{{ $product['quantity'] }}</td>
                    <td>
                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Usuń</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <form action="{{ route('payments.pay') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success">
            Zapłać
        </button>
    </form>

@else
    <p>Twój koszyk jest pusty.</p>
@endif

@if(session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@endif
@endsection
