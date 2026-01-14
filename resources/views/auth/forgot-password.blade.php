@extends('layouts.app')

@section('content')
<main class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card bg-dark text-white border-0">
                <div class="card-body">
                    <h1 class="h4 mb-3">Resetowanie hasła</h1>

                    <p class="mb-3">Podaj swój adres e-mail — prześlemy link do resetu hasła.</p>

                    @if(session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" aria-label="Formularz resetowania hasła">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required class="form-control" autofocus>
                            @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button class="btn btn-warning text-dark">Wyślij link</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
