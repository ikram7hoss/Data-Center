<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Espace Interne</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    .flash-success {
        background: #dcfce7;
        color: #166534;
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
    }

    .internal-card {
        margin-top: 1rem;
    }

    .internal-nav-divider {
        margin-top: 2rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border);
    }
  </style>
</head>
<body>
<div class="app-container">
    <aside class="sidebar">
        <a href="{{ url('/') }}" class="brand">
            <img src="{{ asset('images/bg-tech.png') }}" alt="Logo" style="height: 36px; border-radius: 8px;">
            <span>Data Center</span>
        </a>
        <nav>
            <a href="{{ route('internal.dashboard') }}" class="nav-link {{ request()->routeIs('internal.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Tableau de bord
            </a>
            <a href="{{ route('internal.resources.index') }}" class="nav-link {{ request()->routeIs('internal.resources.*') ? 'active' : '' }}">
                <i class="fas fa-cubes"></i> Ressources
            </a>
            <a href="{{ route('internal.reservations.index') }}" class="nav-link {{ request()->routeIs('internal.reservations.*') ? 'active' : '' }}">
                <i class="fas fa-clipboard-list"></i> Mes demandes
            </a>
            <a href="{{ route('internal.incidents.index') }}" class="nav-link {{ request()->routeIs('internal.incidents.*') ? 'active' : '' }}">
                <i class="fas fa-triangle-exclamation"></i> Incidents
            </a>
            <a href="{{ route('internal.notifications.index') }}" class="nav-link {{ request()->routeIs('internal.notifications.*') ? 'active' : '' }}">
                <i class="fas fa-bell"></i> Notifications
            </a>
            <a href="{{ route('internal.profile') }}" class="nav-link {{ request()->routeIs('internal.profile') ? 'active' : '' }}">
                <i class="fas fa-user"></i> Profil
            </a>

            <div class="internal-nav-divider">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link" style="width: 100%; border: none; background: none; cursor: pointer; text-align: left;">
                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <main class="main-content">
        <header style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem;">
            <div></div>
            <a href="{{ route('internal.profile') }}" style="display: flex; align-items: center; gap: 1rem; text-decoration: none;">
                <div style="text-align: right;">
                    <div style="font-weight: 600; font-size: 0.9rem; color: var(--text-primary); display: flex; align-items: center; gap: 0.5rem; justify-content: flex-end;">
                        {{ Auth::user()->name ?? 'Utilisateur' }}
                        <span class="role-badge">{{ Auth::user()?->academicRoleLabel() ?? 'Utilisateur interne' }}</span>
                    </div>
                    <div style="font-size: 0.75rem; color: var(--text-secondary);">Utilisateur interne</div>
                </div>
                @if(Auth::user()->avatar)
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}"
                         alt="Profile"
                         style="width: 40px; height: 40px; border-radius: 50%; border: 2px solid var(--border); object-fit: cover;">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Utilisateur') }}&background=3b82f6&color=fff"
                         alt="Profile"
                         style="width: 40px; height: 40px; border-radius: 50%; border: 2px solid var(--border);">
                @endif
            </a>
        </header>

        @if(session('success'))
            <div class="flash-success">{{ session('success') }}</div>
        @endif

        <div class="card internal-card internal-page">
            @yield('content')
        </div>
    </main>
</div>
</body>
</html>
