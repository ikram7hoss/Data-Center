<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Espace Interne</title>
  <style>
   
    :root {
        --bg-color: #f0f2f5;
        --card-bg: #ffffff;
        --text-main: #1a202c;
        --primary: #3182ce;
        --danger: #e53e3e;
        --border: #e2e8f0;
    }

    body {
        background-color: var(--bg-color);
        color: var(--text-main);
        font-family: 'Segoe UI', Arial, sans-serif;
        margin: 0;
        line-height: 1.6;
    }


    .navbar {
        background: white;
        padding: 1rem 2rem;
        display: flex;
        align-items: center;
        gap: 15px;
        border-bottom: 2px solid var(--border);
        flex-wrap: wrap;
    }

    .navbar a {
        text-decoration: none;
        color: #4a5568;
        font-weight: 500;
        padding: 8px 12px;
        border-radius: 5px;
    }

    .navbar a:hover {
        background: #edf2f7;
    }


    .container {
        max-width: 1100px;
        margin: 30px auto;
        background: var(--card-bg);
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        min-height: 70vh;
    }

  
    h1, h2, h3 { color: var(--text-main); margin-top: 0; }


    .btn-logout {
        background: none;
        border: 1px solid var(--danger);
        color: var(--danger);
        padding: 6px 15px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
        margin-left: auto;
    }

    .btn-logout:hover { background: #fff5f5; }


    .alert { padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 5px solid; }
    .alert-success { background: #f0fff4; color: #276749; border-color: #38a169; }
  </style>
</head>
<body>

<nav class="navbar">
    <a href="{{ route('internal.dashboard') }}">🏠 Dashboard</a>
    <a href="{{ route('internal.resources.index') }}">📦 Ressources</a>
    <a href="{{ route('internal.reservations.index') }}">📋 Mes demandes</a>
    <a href="{{ route('internal.incidents.index') }}">⚠️ Incidents</a>
    <a href="{{ route('internal.notifications.index') }}">🔔 Notifications</a>
    <a href="{{ route('internal.profile') }}">👤 Profil</a>

    <form action="{{ route('logout') }}" method="POST" class="logout-form" style="margin-left: auto;">
        @csrf
        <button type="submit" class="btn-logout">Déconnexion</button>
    </form>
</nav>

<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @yield('content')
</div>

</body>
</html>