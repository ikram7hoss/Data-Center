@extends('layouts.responsable')

@section('content')
<style>
    /* --- 1. STYLES DES NOTIFICATIONS --- */
    .bell-wrapper { position: relative; display: inline-block; }
    .notif-dropdown {
        display: none; position: absolute; right: 0; top: 45px;
        width: 380px; background: white; border: 1px solid #e2e8f0;
        border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        z-index: 9999; max-height: 500px; overflow-y: auto;
    }
    .notif-dropdown.active { display: block !important; }
    .notif-item {
        display: flex; align-items: center; padding: 15px;
        border-bottom: 1px solid #f1f5f9; transition: 0.2s; text-decoration: none;
    }
    .notif-unread { background-color: #f0f7ff; border-left: 4px solid #ef4444; }

    /* --- 2. STYLES DES BADGES ET LIGNES --- */
    .row-reported { background-color: #fff1f2 !important; }
    .row-approved { background-color: #f0fdf4 !important; }
    .badge {
        padding: 4px 12px; border-radius: 20px; font-size: 11px;
        font-weight: bold; display: inline-flex; align-items: center; gap: 5px;
    }
    .badge-reported { background: #fee2e2; color: #991b1b; border: 1px solid #f87171; }
    .badge-approved { background: #dcfce7; color: #166534; border: 1px solid #4ade80; }
    .badge-pending { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }
</style>

<div style="padding: 30px;">

    {{-- EN-TÊTE --}}
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px;">
        <h1 style="color: #1e3a8a; margin: 0;">Espace Modération</h1>

        @if(session('success'))
            <div id="flash-message" style="position: fixed; top: 20px; right: 20px; background: #dcfce7; color: #166534; padding: 15px; border-radius: 8px; z-index: 10000; border: 1px solid #bbf7d0; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                {{ session('success') }}
            </div>
            <script>setTimeout(() => { document.getElementById('flash-message').style.display = 'none'; }, 3000);</script>
        @endif

        
        </div>
    </div>

    {{-- BARRE DE RECHERCHE --}}
    <div style="margin-bottom: 20px; display: flex; gap: 15px; align-items: center;">
        <div style="position: relative; flex-grow: 1;">
            <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Rechercher une ressource ou un utilisateur..." 
                   style="padding: 12px 15px; width: 100%; border-radius: 10px; border: 1px solid #e2e8f0; outline: none; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        </div>
        
        <select id="statusFilter" onchange="filterTable()" style="padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0; background: white; color: #475569; min-width: 180px;">
            <option value="">Tous les statuts</option>
            <option value="Signalé">⚠️ Signalés</option>
            <option value="Approuvé">✅ Approuvés</option>
            <option value="En attente">🕒 En attente</option>
        </select>
    </div>

    {{-- TABLEAU --}}
    <div style="background: white; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; color: #64748b; font-size: 13px; border-bottom: 1px solid #e2e8f0; background: #f8fafc;">
                    <th style="padding: 15px;">STATUT</th>
                    <th style="padding: 15px;">RESSOURCE</th>
                    <th style="padding: 15px;">EXPÉDITEUR</th>
                    <th style="padding: 15px;">MESSAGE</th>
                    <th style="padding: 15px;">DATE</th>
                    <th style="padding: 15px; text-align: right;">ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @foreach($messages as $msg)
                <tr class="{{ $msg->status == 'reported' ? 'row-reported' : ($msg->status == 'approved' ? 'row-approved' : '') }}" style="border-bottom: 1px solid #f1f5f9; transition: 0.3s;">
                    <td style="padding: 15px;">
                        @if($msg->status == 'reported')
                            <span class="badge badge-reported">⚠️ Signalé</span>
                        @elseif($msg->status == 'approved')
                            <span class="badge badge-approved">✅ Approuvé</span>
                        @else
                            <span class="badge badge-pending">🕒 En attente</span>
                        @endif
                    </td>
                    <td style="padding: 15px; font-weight: bold; color: #1e3a8a;">{{ $msg->ressource->name ?? 'N/A' }}</td>
                    <td style="padding: 15px;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="width: 28px; height: 28px; background: #cbd5e1; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px;">
                                {{ strtoupper(substr($msg->user->name ?? 'U', 0, 1)) }}
                            </div>
                            <span style="font-size: 14px;">{{ $msg->user->name ?? 'Anonyme' }}</span>
                        </div>
                    </td>
                    <td style="padding: 15px; color: #334155; font-size: 14px;">{{ Str::limit($msg->content, 40) }}</td>
                    <td style="padding: 15px; color: #64748b; font-size: 12px;">{{ $msg->created_at->format('d/m/Y | H:i') }}</td>
                    <td style="padding: 15px; text-align: right;">
                        <div style="display: flex; justify-content: flex-end; gap: 8px;">
                            <form action="{{ route('moderation.approve', $msg->id) }}" method="POST">@csrf
                                <button type="submit" style="background: #dcfce7; color: #166534; border:none; padding:8px; border-radius:6px; cursor:pointer;"><i class="fas fa-check"></i></button>
                            </form>
                            <button onclick="viewDetails({{ $msg->id }}, '{{ addslashes($msg->content) }}')" style="background: #e0f2fe; color: #0369a1; border:none; padding:8px; border-radius:6px; cursor:pointer;"><i class="fas fa-eye"></i></button>
                            <form action="{{ route('moderation.report', $msg->id) }}" method="POST">@csrf
                                <button type="submit" style="background: #fef3c7; color: #92400e; border:none; padding:8px; border-radius:6px; cursor:pointer;"><i class="fas fa-flag"></i></button>
                            </form>
                            <form action="{{ route('moderation.delete', $msg->id) }}" method="POST" onsubmit="return confirm('Supprimer définitivement ?')">@csrf @method('DELETE')
                                <button type="submit" style="background: #fee2e2; color: #ef4444; border:none; padding:8px; border-radius:6px; cursor:pointer;"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- MODALE --}}
<div id="modalDetails" style="display:none; position:fixed; z-index:10001; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); backdrop-filter: blur(4px);">
    <div style="background:white; width:550px; margin:10% auto; padding:25px; border-radius:15px;">
        <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #eee; padding-bottom:15px; margin-bottom:20px;">
            <h3 style="margin:0; color:#1e3a8a;">Détails du Message</h3>
            <button onclick="closeModal()" style="background:none; border:none; font-size:28px; cursor:pointer; color:#94a3b8;">&times;</button>
        </div>
        <div id="modalBody" style="background:#f8fafc; padding:20px; border-radius:12px; border-left:5px solid #1e3a8a; color:#334155;"></div>
        <div style="margin-top:25px; text-align:right;">
            <button onclick="closeModal()" style="padding:10px 25px; background:#1e3a8a; color:white; border:none; border-radius:8px; cursor:pointer;">Fermer</button>
        </div>
    </div>
</div>

<script>
    // --- NOTIFICATIONS TEMPS RÉEL ---
    function refreshNotifications() {
    fetch('/api/notifications/latest') // On utilise l'API qui donne aussi les textes
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('notif-count-badge');
            const bell = document.getElementById('bellIcon');
            const container = document.getElementById('notif-list-container');
            
            // 1. Mise à jour du badge
            if (data.count > 0) {
                badge.innerText = data.count;
                badge.style.display = 'block';
                bell.style.color = '#ef4444';

                // 2. Mise à jour dynamique de la liste des messages
                let html = '';
                data.notifications.forEach(n => {
                    html += `
                        <div class="notif-item notif-unread">
                            <div style="width: 35px; height: 35px; background: #1e3a8a; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; flex-shrink: 0;">
                                ${n.title.charAt(0).toUpperCase()}
                            </div>
                            <div style="margin-left: 12px; flex-grow: 1;">
                                <p style="margin:0; font-size: 13px; font-weight: bold;">${n.title}</p>
                                <p style="margin:0; font-size: 12px; color: #64748b;">${n.message}</p>
                            </div>
                        </div>`;
                });
                container.innerHTML = html;
            } else {
                badge.style.display = 'none';
                bell.style.color = '#64748b';
                // Optionnel : ne pas vider la liste si on veut garder l'historique
            }
        });
}

    // On vérifie toutes les 10 secondes
    setInterval(refreshNotifications, 10000);

    // Toggle menu notifications
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('btnNotif');
        const box = document.getElementById('boxNotif');
        btn.addEventListener('click', (e) => { 
            e.stopPropagation(); 
            box.classList.toggle('active'); 
            // On peut aussi masquer le badge dès qu'on ouvre
            //document.getElementById('notif-count-badge').style.display = 'none';
        });
        document.addEventListener('click', (e) => { if (!box.contains(e.target) && !btn.contains(e.target)) box.classList.remove('active'); });
    });

    // Modale
    function viewDetails(id, contenu) {
        document.getElementById('modalBody').innerHTML = `<p>${contenu}</p>`;
        document.getElementById('modalDetails').style.display = 'block';
    }
    function closeModal() { document.getElementById('modalDetails').style.display = 'none'; }

    // Filtre tableau
    function filterTable() {
        let input = document.getElementById("searchInput").value.toUpperCase();
        let status = document.getElementById("statusFilter").value;
        let tr = document.querySelectorAll("tbody tr");

        tr.forEach(row => {
            let textRessource = row.cells[1].textContent.toUpperCase();
            let textUser = row.cells[2].textContent.toUpperCase();
            let textStatus = row.cells[0].textContent;

            let matchesSearch = textRessource.includes(input) || textUser.includes(input);
            let matchesStatus = status === "" || textStatus.includes(status);

            row.style.display = (matchesSearch && matchesStatus) ? "" : "none";
        });
    }
</script>
@endsection