<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Invité - Data Center</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f9; color: #333; line-height: 1.6; padding: 20px; }
        .container { max-width: 1100px; margin: 0 auto; }
        h1 { text-align: center; color: #2c3e50; margin-bottom: 30px; }
        .alert { padding: 15px; background: #d4edda; color: #155724; border-radius: 5px; margin-bottom: 20px; text-align: center; }
        .resource-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
        .card { background: white; border-radius: 8px; padding: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-top: 4px solid #3498db; }
        .card h3 { margin-top: 0; color: #2980b9; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .spec { margin-bottom: 8px; font-size: 0.95em; }
        .spec strong { color: #555; }
        .status { display: inline-block; margin-top: 15px; padding: 5px 12px; border-radius: 15px; font-size: 0.85em; font-weight: bold; }
        .dispo { background: #e8f5e9; color: #2e7d32; }
        .indispo { background: #ffebee; color: #c62828; }
        .btn-container { text-align: center; margin-top: 40px; }
        .btn { padding: 12px 25px; background: #3498db; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; transition: background 0.3s; }
        .btn:hover { background: #2980b9; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Catalogue des Ressources Informatiques</h1>

        @if(session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <div class="resource-grid">
            @forelse($ressources as $res)
            <div class="card">
                <h3>{{ $res->name }}</h3>
                <div class="spec"><strong>Type:</strong> {{ $res->type }}</div>

                <div class="spec"><strong>CPU:</strong> {{ $res->detail->cpu ?? 'N/A' }}</div>
                <div class="spec"><strong>RAM:</strong> {{ $res->detail->ram ?? 'N/A' }} GB</div>
                <div class="spec"><strong>OS:</strong> {{ $res->detail->os ?? 'N/A' }}</div>
                <div class="spec"><strong>Capacité:</strong> {{ $res->detail->stockage ?? 'N/A' }}</div>
                <div class="spec"><strong>Emplacement:</strong> {{ $res->detail->emplacement ?? 'N/A' }}</div>

                <span class="status {{ $res->status == 'disponible' ? 'dispo' : 'indispo' }}">
                    {{ $res->status == 'disponible' ? '● Disponible' : '● Indisponible' }}
                </span>
            </div>
            @empty
                <p style="grid-column: 1 / -1; text-align: center;">Aucune ressource disponible pour le moment.</p>
            @endforelse
        </div>

        <div class="btn-container">
            <a href="/demande-compte" class="btn">Déposer une demande d'ouverture de compte</a>
        </div>
    </div>
</body>
</html>
