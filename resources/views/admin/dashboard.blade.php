@extends('layouts.app')

@section('content')
    <div class="admin-panel container" role="region" aria-labelledby="admin-panel-title">
        <div class="row">
            <aside class="col-md-3 admin-sidebar" aria-label="Panel nawigacji administratora">
                <h2 id="admin-panel-title">Panel Administratora</h2>
                <p class="muted">Witaj w panelu admina!</p>

                <nav class="admin-actions" aria-label="Akcje administracyjne">
                    <ul>
                        <li><a href="{{ route('products.index') }}">Produkty</a></li>
                        <li><a href="{{ route('users.index') }}">Użytkownicy</a></li>
                        <li><a href="{{ route('categories.index') }}">Kategorie</a></li>
                        <li><a href="{{ route('orders.all') }}">Wszystkie zamówienia</a></li>
                    </ul>
                </nav>
            </aside>

            <main class="col-md-9 admin-main">
                <section>
                    <h3>Zarządzanie</h3>
                    <p>Wybierz pozycję z lewego menu, aby zarządzać zasobami sklepu.</p>
                </section>
            </main>
        </div>
    </div>
@endsection
