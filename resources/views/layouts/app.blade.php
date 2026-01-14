<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SlayWear - Sklep</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Vite compiled CSS -->
    @vite(['resources/css/app.css'])

    <!-- Fallback inline CSS if app.css missing -->
    @php
        $cssExists = file_exists(public_path('css/app.css'));
    @endphp

    @if($cssExists)
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @else
        <style>
            .navbar { background:#111 !important; }
            .navbar .nav-link { color: #fff !important; display:block !important; }
            .navbar .nav-link:hover, .navbar .nav-link:focus { color:#ffbf47 !important; text-decoration:underline; }
            .products-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:0; align-items:start; justify-items:stretch; }
            .product-card { width:100%; max-width:none; background:#0a0a0a; color:#fff; padding:0; margin:0; border:0; border-radius:0; box-shadow:none; display:flex; flex-direction:column; height:540px; overflow:hidden; }
            .product-card img { width:100%; height:420px; object-fit:contain; background:#000; margin:0; display:block; }
            .product-card .card-body, .product-card .card-footer { padding:10px 12px; flex:0 0 120px; }
            .product-card h3, .product-card .card-title, .product-card .product-title { color:#fff; margin:0 0 .25rem; font-size:1.15rem; }
            .product-card p, .product-card .card-text, .product-card .description { color: #fff !important; margin:0 0 .4rem; }
            .price { font-weight:800; font-size:1.1rem; color:#fff; }
            .button-buy { border:1px solid #fff; color:#fff; background:transparent; padding:.35rem .6rem; border-radius:3px; }
            .top-carousel .carousel-item img { width:100%; height:360px; object-fit:cover; }
            .col-md-3 { flex: 0 0 33.3333%; max-width: 33.3333%; }
        </style>
    @endif

    <style>
        .skip-to-content {
            position: fixed;
            right: 1rem;
            bottom: 1rem;
            width: auto;
            height: auto;
            padding: 0.45rem 0.7rem;
            background: #ffbf47;
            color: #000;
            border-radius: 4px;
            text-decoration: none;
            z-index: 1400;
            box-shadow: 0 3px 8px rgba(0,0,0,0.18);
            font-weight: 600;
            opacity: 0.95;
        }
        .skip-to-content:focus {
            outline: 3px solid #111;
            transform: translateY(-2px);
            opacity: 1;
        }
        :focus {
            outline: 3px solid #ffbf47;
            outline-offset: 2px;
        }
        .navbar { position: relative; z-index: 1200; }
        .navbar .nav-link, .navbar .btn { position: relative; z-index: 1300; pointer-events: auto !important; }
        .navbar .navbar-nav { display: flex; gap: 1rem; align-items: center; }
        .navbar .nav-item { display: block; }
        .top-carousel, .carousel, .carousel-inner { z-index: 0; }
    </style>
</head>
<body>

<a href="#main-content" class="skip-to-content">Przejdź do treści</a>

<div class="a11y-toolbar" role="region" aria-label="Accessibility controls">
    <button id="a11y-contrast" aria-pressed="false" title="Wysoki kontrast">Kontrast</button>
    <button id="a11y-font-decrease" title="Mniejsza czcionka">A-</button>
    <button id="a11y-font-increase" title="Większa czcionka">A+</button>
    <button id="a11y-reset" title="Resetuj ustawienia">Reset</button>
</div>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}" aria-label="Strona główna SlayWear">
            <span class="fs-4 fw-bold">SlayWear</span>
        </a>
        <ul class="navbar-nav ms-auto">
            @auth
                @if(auth()->user()->role->name === 'Klient')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart') }}">Koszyk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('orders.index') }}">Moje Zamówienia</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile.edit') }}">Profil</a>
                </li>
                @if(auth()->user()->role->name === 'Administrator')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">Panel Admina</a>
                    </li>
                @endif
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button class="nav-link btn btn-link" type="submit">Wyloguj</button>
                    </form>
                </li>
            @else
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Zaloguj</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Rejestracja</a></li>
            @endauth
        </ul>
    </div>
</nav>

@if(session('success'))
    <div class="container">
        <div class="alert alert-success">{{ session('success') }}</div>
    </div>
@endif

<!-- Исправлено: только один main -->
<main id="main-content" class="container">
    @yield('content')
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

<script>
(function(){
    const contrastBtn = document.getElementById('a11y-contrast');
    const incBtn = document.getElementById('a11y-font-increase');
    const decBtn = document.getElementById('a11y-font-decrease');
    const resetBtn = document.getElementById('a11y-reset');

    function applySettings(){
        const contrast = localStorage.getItem('a11y_contrast') === '1';
        const font = localStorage.getItem('a11y_font') || 'normal';

        document.documentElement.classList.toggle('high-contrast', contrast);
        contrastBtn.setAttribute('aria-pressed', contrast ? 'true' : 'false');

        document.documentElement.classList.remove('font-size-large','font-size-xlarge');
        if(font === 'large') document.documentElement.classList.add('font-size-large');
        if(font === 'xlarge') document.documentElement.classList.add('font-size-xlarge');
    }

    contrastBtn?.addEventListener('click', function(){
        const enabled = document.documentElement.classList.toggle('high-contrast');
        localStorage.setItem('a11y_contrast', enabled ? '1' : '0');
        this.setAttribute('aria-pressed', enabled ? 'true' : 'false');
    });

    incBtn?.addEventListener('click', function(){
        const font = localStorage.getItem('a11y_font') || 'normal';
        if(font === 'normal') localStorage.setItem('a11y_font','large');
        else if(font === 'large') localStorage.setItem('a11y_font','xlarge');
        applySettings();
    });

    decBtn?.addEventListener('click', function(){
        const font = localStorage.getItem('a11y_font') || 'normal';
        if(font === 'xlarge') localStorage.setItem('a11y_font','large');
        else if(font === 'large') localStorage.setItem('a11y_font','normal');
        applySettings();
    });

    resetBtn?.addEventListener('click', function(){
        localStorage.removeItem('a11y_contrast');
        localStorage.removeItem('a11y_font');
        applySettings();
    });

    applySettings();
})();
</script>

</body>
</html>
