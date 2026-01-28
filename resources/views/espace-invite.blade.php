<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portail Ressources | Data Center</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --secondary: #64748b;
            --bg-body: #f1f5f9;
            --bg-card: #ffffff;
            --text-main: #1e293b;
            --text-muted: #94a3b8;
            --success: #10b981;
            --border-radius: 16px;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.1);
            --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
            --shadow-hover: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
        }

        @keyframes gradient-bg {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: linear-gradient(-45deg, #f1f5f9, #e2e8f0, #e0f2fe, #f1f5f9);
            background-size: 400% 400%;
            animation: gradient-bg 20s ease infinite;
            color: var(--text-main);
            margin: 0;
            padding: 0;
            line-height: 1.5;
            min-height: 100vh;
        }

        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideDown 0.5s ease-out;
        }
        .navbar-actions {
            animation: slideDown 0.5s ease-out 0.2s backwards;
        }
        .navbar-actions a {
            text-decoration: none;
            color: var(--text-main);
            font-weight: 500;
            margin-left: 20px;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .btn-primary {
            background: var(--primary);
            color: white !important;
            box-shadow: 0 2px 10px rgba(37, 99, 235, 0.2);
        }
        .btn-primary:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        /* Grid */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 4rem 2rem;
        }
        .resource-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 2rem;
        }

        /* Card */
        .resource-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.5);
            display: flex;
            flex-direction: column;
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
        }
        .resource-card:hover {
            box-shadow: var(--shadow-hover);
            background: rgba(255, 255, 255, 0.95);
        }
        .card-header {
            padding: 1.5rem;
            background: linear-gradient(to right, rgba(248, 250, 252, 0.5), rgba(255, 255, 255, 0.5));
            border-bottom: 1px solid rgba(241, 245, 249, 0.8);
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .status-badge.disponible { background: #dcfce7; color: #166534; }
        .status-badge.maintenance { background: #fee2e2; color: #991b1b; }
        .status-badge.reserve { background: #ffedd5; color: #9a3412; }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        .status-badge.disponible .status-dot { background: #22c55e; }
        .status-badge.maintenance .status-dot { background: #ef4444; }
        .status-badge.reserve .status-dot { background: #f97316; }
        .card-body {
            padding: 1.5rem;
            flex-grow: 1;
        }
        .spec-item {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
            color: var(--secondary);
            font-size: 0.95rem;
            transition: transform 0.2s ease;
        }

        .spec-icon {
            width: 32px;
            height: 32px;
            background: #eff6ff;
            color: var(--primary);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        .card-footer {
            padding: 1rem 1.5rem;
            background: rgba(248, 250, 252, 0.5);
            border-top: 1px solid rgba(241, 245, 249, 0.8);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.4); }
            70% { box-shadow: 0 0 0 6px rgba(34, 197, 94, 0); }
            100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
        }
        @keyframes fadeInUp {
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <a href="{{ url('/') }}" class="navbar-brand" style="text-decoration: none;">
            <img src="{{ asset('images/logo-datacenter.jpg') }}" alt="Logo" style="height: 40px; border-radius: 8px;">
            DataCenter Manager
        </a>
        <div class="navbar-actions">
            <a href="{{ route('demande.create') }}">Demander un Compte</a>
            <a href="{{ route('login') }}" class="btn-primary">Connexion</a>
        </div>
    </nav>

    <!-- Header/Search section removed as requested -->

    <div class="container">
        <div class="resource-grid" id="resourceGrid">
            @forelse($resources as $index => $resource)
            <div class="resource-card" style="animation-delay: {{ $index * 0.1 }}s">
                <div class="card-header">
                    <div style="display:flex; justify-content:space-between; align-items:start;">
                        <div>
                            <h3 style="margin:0; font-size:1.1rem; color: var(--text-main);">{{ $resource->name }}</h3>
                            <small style="color:var(--text-muted); text-transform: uppercase; font-size:0.75rem; letter-spacing:0.5px;">{{ $resource->type }}</small>
                        </div>
                        <div class="status-badge {{ $resource->status }}">
                            <span class="status-dot"></span>
                            {{ ucfirst($resource->status) }}
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    @php
                        $specs = [
                            ['icon' => 'fa-microchip', 'label' => 'CPU', 'val' => ($resource->serveur->cpu ?? $resource->machineVirtuelle->cpu ?? 'N/A')],
                            ['icon' => 'fa-memory', 'label' => 'RAM', 'val' => ($resource->serveur->ram ?? $resource->machineVirtuelle->ram ?? 'N/A')],
                            ['icon' => 'fa-hdd', 'label' => 'Stockage', 'val' => ($resource->serveur->stockage ?? $resource->machineVirtuelle->stockage ?? 'N/A')],
                            ['icon' => 'fa-brands fa-linux', 'label' => 'OS', 'val' => ($resource->serveur->os ?? $resource->machineVirtuelle->os ?? 'N/A')]
                        ];
                    @endphp

                    @foreach($specs as $spec)
                        <div class="spec-item">
                            <div class="spec-icon"><i class="fas {{ $spec['icon'] }}"></i></div>
                            <div>
                                <div style="font-size:0.75rem; color:var(--text-muted)">{{ $spec['label'] }}</div>
                                <div style="font-weight:500;">{{ $spec['val'] }}</div>
                            </div>
                        </div>
                    @endforeach

                    @if($resource->location)
                    <div style="margin-top:15px; padding-top:15px; border-top:1px dashed #e2e8f0; display:flex; gap:10px; align-items:center; color:var(--secondary);">
                        <i class="fas fa-map-marker-alt" style="color: #fca5a5;"></i>
                        <span style="font-size:0.9rem;">{{ $resource->location }}</span>
                    </div>
                    @endif
                </div>
                
                <div class="card-footer">
                    <span>ID: <strong>#{{ $resource->id }}</strong></span>
                    <a href="{{ route('demande.create') }}" style="color:var(--primary); text-decoration:none; font-weight:600; font-size:0.85rem;">Réserver <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
            @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 3rem; animation: fadeInUp 0.5s ease-out;">
                <i class="fas fa-inbox" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem;"></i>
                <p style="color: var(--secondary);">Aucune ressource disponible actuellement.</p>
            </div>
            @endforelse
        </div>
    </div>
</body>
</html>
