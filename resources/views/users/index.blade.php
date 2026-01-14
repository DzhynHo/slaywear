@extends('layouts.app')

@section('content')
<main class="container">
    <h1>Użytkownicy</h1>

    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Dodaj użytkownika</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Imię</th>
                <th>Email</th>
                <th>Akcje</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-secondary">Edytuj</a>

                        <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline-block">
                            <x-csrf />
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Usuń</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</main>
@endsection
