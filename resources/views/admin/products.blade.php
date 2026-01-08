@extends('layouts.app')

@section('content')
<h1>Zarządzanie produktami</h1>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Nazwa</th>
            <th>Cena</th>
            <th>Stan</th>
            <th>Akcje</th>
        </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->price }} zł</td>
            <td>{{ $product->stock }}</td>
            <td>
                <a href="/products/{{ $product->id }}/edit" class="btn btn-warning btn-sm">Edytuj</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
