<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <title>Internal</title>
</head>
<body>
    <nav class="nav">
  <a href="{{ route('resources.index') }}">Ressources</a>
  <a href="{{ route('reservations.index') }}">Mes demandes</a>
  <a href="{{ route('reservations.create') }}">Nouvelle demande</a>
</nav>
<hr>

  @yield('content')
</body>
</html>
