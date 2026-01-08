<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>SLAYWEAR</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<a class="visually-hidden-focusable" href="#content">Przejdź do treści</a>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark" role="navigation">
    <div class="container">
        <a class="navbar-brand" href="/">SLAYWEAR</a>
    </div>
</nav>

<main id="content" class="container mt-4" role="main">
    @yield('content')
</main>

<footer class="bg-dark text-white text-center p-3 mt-4" role="contentinfo">
    © 2026 SLAYWEAR
</footer>

</body>
</html>
