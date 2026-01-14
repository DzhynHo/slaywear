@extends('layouts.app')

@section('content')
<main class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card bg-dark text-white border-0">
                <div class="card-body">
                    <h1 class="h4 mb-3">Zaloguj się</h1>

                    @if(session('status'))
                        <div class="alert alert-info">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" aria-label="Formularz logowania">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control">
                            @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Hasło</label>
                            <input id="password" type="password" name="password" required class="form-control">
                            @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input id="remember_me" type="checkbox" name="remember" class="form-check-input">
                            <label for="remember_me" class="form-check-label">Zapamiętaj mnie</label>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-warning">Zapomniałeś hasła?</a>
                                @endif
                            </div>
                            <div>
                                <button class="btn btn-warning text-dark">Zaloguj</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
