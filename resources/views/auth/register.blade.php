@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card bg-dark text-white border-0">
                <div class="card-body">
                    <h1 class="h4 mb-3">Zarejestruj się</h1>

                    <form method="POST" action="{{ route('register') }}" aria-label="Formularz rejestracji">
                        <x-csrf />

                        <div class="mb-3">
                            <label for="name" class="form-label">Imię i nazwisko</label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" required class="form-control" autofocus>
                            @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required class="form-control">
                            @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Hasło</label>
                            <input id="password" name="password" type="password" required class="form-control">
                            @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Potwierdź hasło</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" required class="form-control">
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('login') }}" class="text-warning">Masz już konto? Zaloguj się</a>
                            <button class="btn btn-warning text-dark">Zarejestruj</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
