<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataCenter - Responsable Technique</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* RESET & BASE */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            display: flex;
            color: #333;
        }

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
            margin-left: 250px;
            /* Largeur de la sidebar */
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
            {{-- Lien Ressources --}}
            <a href="{{ route('resp.dashboard') }}" class="nav-item {{ request()->routeIs('resp.dashboard') ? 'active' : '' }}">
                <i class="fas fa-server"></i>
                <span>Mes Ressources</span>
            </a>

            {{-- Lien Demandes --}}
            <a href="{{ route('responsable.demandes') }}" class="nav-item {{ request()->is('responsable/demandes*') ? 'active' : '' }}">
                <i class="fas fa-envelope"></i>
                <span>Demandes</span>
            </a>

            {{-- Lien Modération UNIQUE et PROPRE --}}
            <a href="{{ route('responsable.moderation') }}" class="nav-item {{ request()->routeIs('responsable.moderation') ? 'active' : '' }}">
                <i class="fas fa-comments"></i>
                <span>Modération</span>
            </a>
        </nav>
    </div>

    <div class="main-content">
        <header class="top-bar" style="display: flex; justify-content: flex-end; align-items: center; padding: 10px 30px; background: white; border-bottom: 1px solid #e2e8f0;">
            <div class="user-info" style="display: flex; align-items: center; gap: 15px;">

                <div class="bell-wrapper" style="position: relative;">
                    <div id="btnNotif" style="cursor: pointer; position: relative; display: flex; align-items: center; padding: 5px;">
                        <svg id="bellIcon" style="width: 24px; height: 24px; color: #64748b; transition: 0.3s;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span id="notif-count-badge" style="position: absolute; top: -2px; right: -2px; background: #ef4444; color: white; border-radius: 50%; padding: 2px 5px; font-size: 10px; border: 2px solid white; display: none;">0</span>
                    </div>

                    <div id="boxNotif" class="notif-dropdown" style="display: none; position: absolute; right: 0; top: 40px; width: 300px; background: white; border: 1px solid #e2e8f0; border-radius: 10px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); z-index: 1000;">
                        <div style="padding: 12px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-weight: bold; color: #1e3a8a; font-size: 14px;">Notifications</span>
                            <button id="clearNotifsBtn" title="Tout effacer" style="background: none; border: none; color: #94a3b8; cursor: pointer; transition: 0.3s; padding: 5px;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>

                        <div id="notif-list-container" style="max-height: 300px; overflow-y: auto;">
                            <p style="padding: 15px; text-align: center; color: #94a3b8; font-size: 13px;">Aucune notification</p>
                        </div>
                    </div>
                </div>

                <span style="font-size: 14px; color: #334155;">Bienvenue, <strong>{{ Auth::user()->name ?? 'Responsable' }}</strong></span>
                <i class="fas fa-user-circle fa-2x" style="color: #64748b;"></i>

            </div>
        </header>

        <main class="container">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
    <script>
        function refreshNotifications() {
            fetch('/api/notifications/latest')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('notif-count-badge');
                    const container = document.getElementById('notif-list-container');
                    const box = document.getElementById('boxNotif');

                    if (data.count > 0 && box.style.display === 'none') {
                        badge.innerText = data.count;
                        badge.style.display = 'block';
                    } else if (data.count === 0) {
                        badge.style.display = 'none';
                    }

                    // Update List
                    if (data.notifications.length > 0) {
                        let html = '';
                        data.notifications.forEach(n => {
                            html += `
                        <div class="notif-item notif-unread">
                            <div style="margin-left: 10px;">
                                <p style="margin:0; font-size: 13px; font-weight: bold;">Nouveau Signalement</p>
                                <p style="margin:0; font-size: 12px; color: #64748b;">${n.content ? n.content.substring(0, 50) : ''}...</p>
                            </div>
                        </div>`;
                        });
                        container.innerHTML = html;
                    } else {
                        container.innerHTML = '<p style="padding: 15px; text-align: center; color: #94a3b8; font-size: 13px;">Aucune notification</p>';
                    }
                });
        }

        // Toggle logic (Open/Close the dropdown)
        document.getElementById('btnNotif').addEventListener('click', function(e) {
            e.stopPropagation();
            const box = document.getElementById('boxNotif');
            const badge = document.getElementById('notif-count-badge');

            const isOpening = box.style.display === 'none';
            box.style.display = isOpening ? 'block' : 'none';

            // When opening the notifications, hide the red badge (set count to 0 visually)
            if (isOpening) {
                badge.style.display = 'none';
            }
        });

        // Logic for the Trash Bin Button
        document.getElementById('clearNotifsBtn').addEventListener('click', function(e) {
            e.stopPropagation();

            if (!confirm('Voulez-vous effacer toutes les notifications ?')) return;

            fetch('/api/notifications/clear', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('notif-count-badge').style.display = 'none';
                    document.getElementById('notif-list-container').innerHTML =
                        '<p style="padding: 15px; text-align: center; color: #94a3b8; font-size: 13px;">Aucune notification</p>';
                })
                .catch(error => console.error('Error clearing notifications:', error));
        });

        //document.addEventListener('click', function() {
        // document.getElementById('boxNotif').style.display = 'none';
        //});
       document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('btnNotif');
    const box = document.getElementById('boxNotif');
    const badge = document.getElementById('notif-count-badge');
    const bell = document.getElementById('bellIcon');

    btn.onclick = function(e) {
        e.stopPropagation();
        
        // إذا كانت القائمة ستفتح الآن
        if (box.style.display === 'none' || box.style.display === '') {
            box.style.display = 'block';

            // 1. إخفاء الرقم فوراً من الواجهة (UX)
            badge.style.display = 'none';
            bell.style.color = '#64748b';

            // 2. إرسال طلب التحديث لقاعدة البيانات
            fetch('/api/notifications/mark-as-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log("Status updated in DB");
                // نقوم بتصفير المصفوفة محلياً لمنع دالة التحديث من إظهاره مجدداً
                if (window.lastNotifData) {
                    window.lastNotifData.count = 0;
                }
            })
            .catch(error => console.error('Erreur:', error));
        } else {
            box.style.display = 'none';
        }
    };
});


       setInterval(refreshNotifications, 10000);
        refreshNotifications();
    </script>
</body>

</html>