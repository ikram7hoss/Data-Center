<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Data Center</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="brand">
                <i class="fas fa-server"></i> Data Center
            </div>
            
            <nav>
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i> Tableau de bord
                </a>
                <a href="{{ route('admin.statistics') }}" class="nav-link {{ request()->routeIs('admin.statistics') ? 'active' : '' }}">
                    <i class="fas fa-chart-pie"></i> Statistiques
                </a>
                <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Utilisateurs
                </a>
                <a href="{{ route('admin.resources') }}" class="nav-link {{ request()->routeIs('admin.resources') ? 'active' : '' }}">
                    <i class="fas fa-cubes"></i> Ressources
                </a>
                <a href="{{ route('admin.demandes') }}" class="nav-link {{ request()->routeIs('admin.demandes') ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list"></i> Demandes
                </a>
                <a href="{{ route('admin.maintenance') }}" class="nav-link {{ request()->routeIs('admin.maintenance') ? 'active' : '' }}">
                    <i class="fas fa-tools"></i> Maintenance
                </a>
                
                <div style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid var(--border);">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link" style="width: 100%; border: none; background: none; cursor: pointer; text-align: left;">
                            <i class="fas fa-sign-out-alt"></i> Déconnexion
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <header class="flex justify-between items-center mb-3" style="margin-bottom: 2rem;">
                <!-- Breadcrumb or Title Placeholder (Optional, can be left empty to push right) -->
                <div></div> 

                <div class="flex items-center gap-2" style="gap: 1.5rem;">
                    <!-- Notification Bell -->
                    <div style="position: relative; cursor: pointer;" onclick="toggleNotifications()">
                        <i class="fas fa-bell" style="font-size: 1.2rem; color: var(--text-secondary);"></i>
                        
                        @if($unreadNotifications->count() > 0)
                            <span id="notificationBadge" style="position: absolute; top: -5px; right: -5px; width: 10px; height: 10px; background: var(--accent); border-radius: 50%; border: 2px solid var(--bg-app);"></span>
                        @endif

                        <!-- Notification Dropdown -->
                        <div id="notificationDropdown" style="display: none; position: absolute; top: 35px; right: 0; width: 300px; background: var(--bg-surface); border: 1px solid var(--border); border-radius: var(--radius-md); box-shadow: 0 10px 40px rgba(0,0,0,0.5); z-index: 1000; overflow: hidden; animation: fadeIn 0.2s;">
                            <div style="padding: 1rem; border-bottom: 1px solid var(--border); font-weight: 600; font-size: 0.9rem;">
                                Notifications
                            </div>
                            
                            <div style="max-height: 300px; overflow-y: auto;">
                                @forelse($unreadNotifications as $notif)
                                    <div style="padding: 0.75rem 1rem; border-bottom: 1px solid var(--border); transition: 0.2s;">
                                        <div style="font-size: 0.85rem; font-weight: 600; color: var(--text-primary); margin-bottom: 2px;">
                                            {{ $notif->title }}
                                        </div>
                                        <div style="font-size: 0.8rem; color: var(--text-secondary);">
                                            {{ $notif->message }}
                                        </div>
                                        <div style="font-size: 0.7rem; color: var(--text-secondary); margin-top: 4px; text-align: right;">
                                            {{ $notif->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                @empty
                                    <div style="padding: 1.5rem; text-align: center; color: var(--text-secondary); font-size: 0.9rem;">
                                        <i class="fas fa-bell-slash" style="font-size: 1.5rem; margin-bottom: 0.5rem; display: block; opacity: 0.5;"></i>
                                        Pas de notification
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Profile -->
                    <!-- Profile -->
                    <a href="{{ route('admin.profile') }}" class="flex items-center gap-2" style="gap: 1rem; padding-left: 1.5rem; border-left: 1px solid var(--border); text-decoration: none;">
                        <div style="text-align: right;">
                            <div style="font-weight: 600; font-size: 0.9rem; color: var(--text-primary);">{{ Auth::user()->name ?? 'Admin' }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-secondary);">Administrateur</div>
                        </div>
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" 
                                 alt="Profile" 
                                 style="width: 40px; height: 40px; border-radius: 50%; border: 2px solid var(--border); object-fit: cover;">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=3b82f6&color=fff" 
                                 alt="Profile" 
                                 style="width: 40px; height: 40px; border-radius: 50%; border: 2px solid var(--border);">
                        @endif
                    </a>
                </div>
            </header>
            @if(session('success'))
                <div style="background: #dcfce7; color: #166534; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
    
    <!-- Custom JS for Motion -->
    <script src="{{ asset('js/admin.js') }}"></script>
    <script>
        function toggleNotifications() {
            const dropdown = document.getElementById('notificationDropdown');
            const badge = document.getElementById('notificationBadge');

            if (dropdown.style.display === 'none') {
                dropdown.style.display = 'block';
                
                // If badge exists, hide it and mark as read
                if (badge) {
                    badge.style.display = 'none'; // Visual feedback immediately
                    
                    // Call backend to mark as read
                    fetch('{{ route("admin.notifications.read") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    });
                }

            } else {
                dropdown.style.display = 'none';
            }
        }

        // Close when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('notificationDropdown');
            const bell = document.querySelector('.fa-bell').parentNode; // The notification container
            
            if (dropdown.style.display === 'block' && !bell.contains(event.target)) {
                dropdown.style.display = 'none';
            }
        });
    </script>
</body>
</html>
