@extends('layouts.app')

@section('content')
<h1>{{ $product->name }}</h1>
<p>{{ $product->description }}</p>
<p>Cena: ${{ $product->price }}</p>
<p>Kategoria: {{ $product->category->name }}</p>
@endsection
