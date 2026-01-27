<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataCenter - Responsable Technique</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* RESET & BASE */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; display: flex; color: #333; }

        /* SIDEBAR (Barre latérale) */
        .sidebar {
            width: 250px;
            background-color: #ffffff;
            height: 100vh;
            border-right: 1px solid #e0e0e0;
            position: fixed;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 20px;
            font-size: 1.2rem;
            font-weight: bold;
            color: #2c3e50;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-links {
            flex-grow: 1;
            padding: 20px 0;
        }

        .nav-item {
            padding: 12px 25px;
            display: flex;
            align-items: center;
            gap: 15px;
            text-decoration: none;
            color: #607d8b;
            transition: all 0.3s ease;
        }

        .nav-item:hover {
            background-color: #f0f4f8;
            color: #00bcd4;
        }

        .nav-item.active {
            background-color: #e0f7fa;
            color: #00bcd4;
            border-right: 4px solid #00bcd4;
        }

        /* MAIN CONTENT AREA */
        .main-content {
            margin-left: 250px; /* Largeur de la sidebar */
            width: calc(100% - 250px);
            min-height: 100vh;
        }

        .top-bar {
            background: #ffffff;
            height: 60px;
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            border-bottom: 1px solid #e0e0e0;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
        }

        .container {
            padding: 30px;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-database" style="color: #00bcd4;"></i>
            <span>DataCenter</span>
        </div>
        
        <nav class="nav-links">
            <a href="{{ route('resp.dashboard') }}" class="nav-item {{ request()->routeIs('resp.dashboard') ? 'active' : '' }}">
                <i class="fas fa-server"></i>
                <span>Mes Ressources</span>
            </a>
           <li class="nav-item">
           <a href="{{ route('responsable.demandes') }}" class="nav-link {{ request()->is('responsable/demandes') ? 'active' : '' }}">
           <i class="fas fa-envelope"></i>
           <span>Demandes</span>
           </a>
           </li>
                
            <a href="#" class="nav-item">
                <i class="fas fa-comments"></i>
                <span>Modération</span>
            </a>
        </nav>
    </div>

    <div class="main-content">
        <header class="top-bar">
            <div class="user-info">
                <span>Bienvenue, <strong>{{ Auth::user()->name ?? 'Responsable' }}</strong></span>
                <i class="fas fa-user-circle fa-lg"></i>
            </div>
        </header>

        <main class="container">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>