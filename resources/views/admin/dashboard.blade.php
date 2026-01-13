@extends('layouts.app')

@section('content')
    <h1>Panel Administratora</h1>
    <p>Witaj w panelu admina!</p>

    <h2>Zarządzanie</h2>
    <ul>
        <li><a href="{{ route('products.index') }}">Produkty</a></li>
        <li><a href="{{ route('users.index') }}">Użytkownicy</a></li>
        <li><a href="{{ route('categories.index') }}">Kategorie</a></li>
        <li><a href="{{ route('orders.all') }}">Wszystkie zamówienia</a></li>
    </ul>
@endsection
