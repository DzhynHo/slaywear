@extends('layouts.app')

@section('content')
<main class="container" role="main">
    <div class="admin-panel">
        <div class="row">
            <aside class="col-md-3 admin-sidebar" aria-hidden="true">
                {{-- simple placeholder to keep layout consistent --}}
                <p class="muted">Kategorie</p>
            </aside>

            <section class="col-md-9 admin-main" aria-labelledby="create-category-title">
                <h1 id="create-category-title">Dodaj nową kategorię</h1>

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('categories.store') }}" aria-labelledby="create-category-title">
                    <x-csrf />

                    <div class="mb-3">
                        <label for="name" class="form-label">Nazwa kategorii</label>
                        <input id="name" name="name" type="text" class="form-control" required autofocus aria-required="true">
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Zapisz kategorię</button>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Powrót</a>
                    </div>
                </form>
            </section>
        </div>
    </div>
</main>
@endsection
