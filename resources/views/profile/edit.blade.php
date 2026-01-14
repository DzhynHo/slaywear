@extends('layouts.app')

@section('content')
<h1>Twój profil</h1>

<form method="POST" action="{{ route('profile.update') }}">
    <x-csrf />
    @method('PATCH')

    <label>Imię i nazwisko:</label>
    <input type="text" name="name" value="{{ auth()->user()->name }}" required>

    <label>Email:</label>
    <input type="email" name="email" value="{{ auth()->user()->email }}" required>

    <button type="submit">Zapisz</button>
</form>
@endsection
