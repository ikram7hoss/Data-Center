@extends('layouts.responsable')

@section('content')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<div class="main-container fade-in">
    <!-- Header Section -->
    <div class="header-section" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 1.8rem; font-weight: 700; color: var(--text-primary); letter-spacing: -0.5px;">Gestion des ressources</h1>
            <p style="color: var(--text-secondary); margin-top: 5px;">Panneau de contrôle technique</p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <div style="position: relative;">
                <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-secondary);"></i>
                <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Rechercher une ressource..." 
                       style="padding: 10px 15px 10px 40px; border-radius: 10px; border: 1px solid var(--border); background: var(--bg-surface); color: var(--text-primary); outline: none; width: 250px; transition: all 0.3s; box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);">
            </div>
            <button class="btn-primary" onclick="openCreateModal()" 
                    style="background: var(--accent); color: white; padding: 10px 25px; border-radius: 10px; border: none; cursor: pointer; font-weight: 600; box-shadow: 0 4px 15px var(--accent-glow); display: flex; align-items: center; gap: 8px; transition: transform 0.2s;">
                <i class="fas fa-plus"></i> Nouveau
            </button>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card" style="background: var(--bg-surface); border-radius: 16px; border: 1px solid var(--border); box-shadow: 0 10px 30px rgba(0,0,0,0.2); overflow: hidden; backdrop-filter: blur(10px);">
        <div class="table-responsive">
            <table id="resourcesTable" style="width: 100%; border-collapse: collapse;">
                <thead style="background: rgba(255,255,255,0.03); border-bottom: 1px solid var(--border);">
                    <tr>
                        <th style="padding: 1.2rem; text-align: left; color: var(--text-secondary); font-weight: 600; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">Ressource</th>
                        <th style="padding: 1.2rem; text-align: left; color: var(--text-secondary); font-weight: 600; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">Type</th>
                        <th style="padding: 1.2rem; text-align: left; color: var(--text-secondary); font-weight: 600; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">Emplacement</th>
                        <th style="padding: 1.2rem; text-align: left; color: var(--text-secondary); font-weight: 600; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">Statut</th>
                        <th style="padding: 1.2rem; text-align: right; color: var(--text-secondary); font-weight: 600; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($resources as $r)
                    <tr class="resource-row" style="border-bottom: 1px solid var(--border); transition: all 0.2s hover;">
                        <td style="padding: 1.2rem;">
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(59, 130, 246, 0.1); display: flex; align-items: center; justify-content: center; color: var(--accent);">
                                    <i class="fas fa-server"></i>
                                </div>
                                <div>
                                    <strong style="color: var(--text-primary); font-size: 0.95rem; display: block;">{{ $r->name }}</strong>
                                    <small style="color: var(--text-secondary); font-size: 0.8rem;">{{ $r->serveur->ip_address ?? 'N/A' }}</small>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 1.2rem; color: var(--text-secondary); font-weight: 500;">
                            <span style="background: rgba(255,255,255,0.05); padding: 5px 10px; border-radius: 6px; font-size: 0.85rem;">
                                {{ $r->type }}
                            </span>
                        </td>
                        <td style="padding: 1.2rem; color: var(--text-secondary);">
                            <i class="fas fa-map-marker-alt" style="margin-right: 5px; opacity: 0.5;"></i>
                            {{ $r->location ?? 'Non défini' }}
                        </td>
                        <td style="padding: 1.2rem;">
                            @php
                                $statusClass = match($r->status) {
                                    'disponible' => 'bg-emerald-500/10 text-emerald-500 border-emerald-500/20',
                                    'maintenance' => 'bg-amber-500/10 text-amber-500 border-amber-500/20',
                                    'reserve' => 'bg-blue-500/10 text-blue-500 border-blue-500/20',
                                    default => 'bg-slate-500/10 text-slate-500 border-slate-500/20'
                                };
                                $statusLabel = ucfirst($r->status);
                            @endphp
                            <span style="padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; border: 1px solid transparent;" class="{{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                        </td>
                        <td style="padding: 1.2rem; text-align: right; position: relative;">
                            <button onclick="toggleMenu('menu-{{ $r->id }}')" 
                                    style="width: 32px; height: 32px; border-radius: 8px; border: 1px solid var(--border); background: transparent; color: var(--text-secondary); cursor: pointer; transition: all 0.2s;">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            
                            <!-- Dropdown -->
                            <div id="menu-{{ $r->id }}" class="dropdown-menu" 
                                 style="display:none; position:absolute; right: 1.5rem; top: 3.5rem; background: var(--bg-surface); border: 1px solid var(--border); border-radius: 10px; box-shadow: 0 10px 40px rgba(0,0,0,0.5); width: 180px; z-index: 50; overflow: hidden; animation: slideDown 0.2s ease-out;">
                                <a href="javascript:void(0)" 
                                   class="dropdown-item"
                                   data-resource='@json($r)'
                                   data-serveur='@json($r->serveur)'
                                   onclick="handleEditClick(this)"
                                   style="display:flex; align-items: center; padding: 12px 15px; text-decoration:none; color: var(--text-secondary); font-size: 0.9rem; transition: all 0.2s; border-bottom: 1px solid rgba(255,255,255,0.03);">
                                   <i class="fas fa-edit" style="width: 20px; color: var(--accent);"></i> Modifier
                                </a>
                                <a href="#" style="display:flex; align-items: center; padding: 12px 15px; text-decoration:none; color: #ef4444; font-size: 0.9rem; transition: all 0.2s;">
                                    <i class="fas fa-trash-alt" style="width: 20px;"></i> Supprimer
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($resources->isEmpty())
        <div style="text-align: center; padding: 4rem;">
            <i class="fas fa-server" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 1rem; opacity: 0.3;"></i>
            <p style="color: var(--text-secondary);">Aucune ressource trouvée.</p>
        </div>
        @endif
    </div>
</div>

<style>
    /* Styling Updates */
    .fade-in { animation: fadeIn 0.5s ease-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
    
    .resource-row:hover { background: rgba(255,255,255,0.02); }
    .dropdown-item:hover { background: rgba(255,255,255,0.05); color: var(--text-primary) !important; padding-left: 20px !important; }
    
    /* Tailwind-like utility classes for status badges (simulated) */
    .bg-emerald-500\/10 { background: rgba(16, 185, 129, 0.1); }
    .text-emerald-500 { color: #10b981; }
    .border-emerald-500\/20 { border-color: rgba(16, 185, 129, 0.2) !important; }

    .bg-amber-500\/10 { background: rgba(245, 158, 11, 0.1); }
    .text-amber-500 { color: #f59e0b; }
    .border-amber-500\/20 { border-color: rgba(245, 158, 11, 0.2) !important; }

    .bg-blue-500\/10 { background: rgba(59, 130, 246, 0.1); }
    .text-blue-500 { color: #3b82f6; }
    .border-blue-500\/20 { border-color: rgba(59, 130, 246, 0.2) !important; }

    .bg-slate-500\/10 { background: rgba(148, 163, 184, 0.1); }
    .text-slate-500 { color: #94a3b8; }
    .border-slate-500\/20 { border-color: rgba(148, 163, 184, 0.2) !important; }
</style>

<script src="{{ asset('js/app.js') }}"></script>
<script>
    // Real-time Search Filter
    function filterTable() {
        let input = document.getElementById("searchInput");
        let filter = input.value.toUpperCase();
        let table = document.getElementById("resourcesTable");
        let tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) { // Start at 1 to skip header
            let tdName = tr[i].getElementsByTagName("td")[0];
            let tdType = tr[i].getElementsByTagName("td")[1];
            if (tdName || tdType) {
                let txtValueName = tdName.textContent || tdName.innerText;
                let txtValueType = tdType.textContent || tdType.innerText;
                if (txtValueName.toUpperCase().indexOf(filter) > -1 || txtValueType.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    tr[i].style.animation = "fadeIn 0.3s ease-out";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>

<!-- Create Modal -->
<div id="createModal" class="modal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.7); backdrop-filter: blur(8px); animation: fadeIn 0.2s;">
    <div class="modal-content" style="background-color: var(--bg-surface); margin: 5% auto; padding: 0; border-radius: 16px; width: 800px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); border: 1px solid var(--border); overflow: hidden; font-family: 'Inter', sans-serif;">
        
        <div style="padding: 24px 32px; border-bottom: 1px solid var(--border); background: linear-gradient(to right, rgba(255,255,255,0.02), transparent);">
            <h2 style="margin: 0; font-size: 1.5rem; color: var(--text-primary); display: flex; align-items: center; gap: 10px;">
                <i class="fas fa-plus-circle" style="color: var(--accent);"></i> Ajouter une Ressource
            </h2>
        </div>

        <form action="{{ route('resource.store') }}" method="POST" style="padding: 32px;">
            @csrf
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                <!-- Left Column -->
                <div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 8px; font-weight: 600;">Nom de la ressource *</label>
                        <input type="text" name="name" placeholder="ex: SRV-PROD-01" class="form-input" required>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 8px; font-weight: 600;">Processeur (CPU)</label>
                        <input type="text" name="cpu" placeholder="ex: Intel Xeon Gold 6248" class="form-input">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 8px; font-weight: 600;">Stockage</label>
                        <input type="text" name="stockage" placeholder="ex: 4TB NVMe RAID 10" class="form-input">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 8px; font-weight: 600;">Système d'exploitation</label>
                        <input type="text" name="os" placeholder="ex: Ubuntu 22.04 LTS" class="form-input">
                    </div>
                </div>

                <!-- Right Column -->
                <div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 8px; font-weight: 600;">Catégorie *</label>
                        <select name="type" class="form-select">
                            <option value="Serveur Physique">Serveur Physique</option>
                            <option value="Machine Virtuelle">Machine Virtuelle</option>
                            <option value="Equipement Reseau">Équipement Réseau</option>
                        </select>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 8px; font-weight: 600;">Mémoire (RAM)</label>
                        <input type="text" name="ram" placeholder="ex: 128 GB DDR4" class="form-input">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 8px; font-weight: 600;">Adresse IP</label>
                        <input type="text" name="ip_address" placeholder="ex: 10.0.0.15" class="form-input">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 8px; font-weight: 600;">Emplacement physique</label>
                        <input type="text" name="location" placeholder="ex: Salle Serveur 1, Baie 4U" class="form-input">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 8px; font-weight: 600;">Statut initial</label>
                        <select name="status" class="form-select">
                            <option value="disponible">Disponible</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="reserve">Réservé</option>
                        </select>
                    </div>
                </div>
            </div>

            <div style="margin-top: 24px;">
                <label style="display: block; font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 8px; font-weight: 600;">Description & Notes</label>
                <textarea name="description" rows="3" class="form-input" style="resize: vertical;"></textarea>
            </div>

            <div style="margin-top: 32px; display: flex; justify-content: flex-end; gap: 12px;">
                <button type="button" onclick="closeCreateModal()" class="btn-secondary">Annuler</button>
                <button type="submit" class="btn-primary-modal">Créer la ressource</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.7); backdrop-filter: blur(8px); animation: fadeIn 0.2s;">
    <div class="modal-content" style="background-color: var(--bg-surface); margin: 5% auto; padding: 0; border-radius: 16px; width: 800px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); border: 1px solid var(--border); overflow: hidden;">
        <div style="padding: 24px 32px; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; background: linear-gradient(to right, rgba(255,255,255,0.02), transparent);">
            <h2 style="margin: 0; font-size: 1.5rem; color: var(--text-primary); font-weight: 600; display: flex; align-items: center; gap: 10px;">
                 <i class="fas fa-edit" style="color: var(--accent);"></i> Modifier la Ressource
            </h2>
            <button type="button" onclick="closeEditModal()" style="background:none; border:none; font-size:24px; cursor:pointer; color: var(--text-secondary); transition: color 0.2s;">&times;</button>
        </div>

        <form id="editForm" method="POST" style="overflow-y: auto; flex-grow: 1;">
            @csrf
            @method('PUT')

            <div style="padding: 32px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                    <!-- Edit Left -->
                    <div>
                        <div style="margin-bottom: 20px;">
                            <label class="form-label">Nom *</label>
                            <input type="text" id="edit_name" name="name" class="form-input" required>
                        </div>
                        <div style="margin-bottom: 20px;">
                            <label class="form-label">CPU</label>
                            <input type="text" id="edit_cpu" name="cpu" class="form-input">
                        </div>
                        <div style="margin-bottom: 20px;">
                            <label class="form-label">Stockage</label>
                            <input type="text" id="edit_stockage" name="stockage" class="form-input">
                        </div>
                        <div style="margin-bottom: 20px;">
                            <label class="form-label">OS</label>
                            <input type="text" id="edit_os" name="os" class="form-input">
                        </div>
                    </div>

                    <!-- Edit Right -->
                    <div>
                        <div style="margin-bottom: 20px;">
                            <label class="form-label">Catégorie *</label>
                            <select id="edit_type" name="type" class="form-select">
                                <option value="Serveur Physique">Serveur Physique</option>
                                <option value="Machine Virtuelle">Machine Virtuelle</option>
                                <option value="Equipement Reseau">Équipement Réseau</option>
                            </select>
                        </div>
                        <div style="margin-bottom: 20px;">
                            <label class="form-label">RAM</label>
                            <input type="text" id="edit_ram" name="ram" class="form-input">
                        </div>
                        <div style="margin-bottom: 20px;">
                            <label class="form-label">IP</label>
                            <input type="text" id="edit_ip_address" name="ip_address" class="form-input">
                        </div>
                        <div style="margin-bottom: 20px;">
                            <label class="form-label">Emplacement</label>
                            <input type="text" id="edit_location" name="location" class="form-input">
                        </div>
                        <div style="margin-bottom: 20px;">
                            <label class="form-label">Statut</label>
                            <select id="edit_status" name="status" class="form-select">
                                <option value="disponible">Disponible</option>
                                <option value="maintenance">Maintenance</option>
                                <option value="reserve">Réservé</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 10px;">
                    <label class="form-label">Description</label>
                    <textarea id="edit_description" name="description" rows="3" class="form-input" style="resize: vertical;"></textarea>
                </div>

                <div style="margin-top: 32px; display: flex; justify-content: flex-end; gap: 12px;">
                    <button type="button" onclick="closeEditModal()" class="btn-secondary">Annuler</button>
                    <button type="submit" class="btn-primary-modal">Enregistrer</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function openCreateModal() {
        document.getElementById('createModal').style.display = 'block';
    }

    function closeCreateModal() {
        document.getElementById('createModal').style.display = 'none';
    }

    // Toggle Dropdown Menu
    function toggleMenu(id) {
        // Close all other menus first
        document.querySelectorAll('.dropdown-menu').forEach(el => { // Changed from .dropdown-content
            if (el.id !== id) el.style.display = 'none';
        });
        
        var menu = document.getElementById(id);
        if (menu.style.display === "block") {
            menu.style.display = "none";
        } else {
            menu.style.display = "block";
        }
    }

    function handleEditClick(element) {
        try {
            // 1. Parse data
            const resource = JSON.parse(element.getAttribute('data-resource'));
            // server data might be null if not loaded or if relation is missing
            const serveur = element.getAttribute('data-serveur') ? JSON.parse(element.getAttribute('data-serveur')) : {};
            
            console.log("Resource:", resource);

            // 2. Set Form Action
            const form = document.getElementById('editForm');
            if (form) form.action = `/responsable/resource/${resource.id}/update`;

            // 3. Fill Main Fields
            const setVal = (id, val) => {
                const el = document.getElementById(id);
                if (el) el.value = val || '';
            };

            setVal('edit_name', resource.name);
            setVal('edit_type', resource.type);
            setVal('edit_location', resource.location);
            setVal('edit_status', resource.status);
            setVal('edit_description', resource.description);

            // 4. Fill Server Fields
            if (serveur) {
                setVal('edit_cpu', serveur.cpu);
                setVal('edit_ram', serveur.ram);
                setVal('edit_stockage', serveur.stockage); // or 'storage' depending on DB column
                setVal('edit_os', serveur.os);
                setVal('edit_ip_address', serveur.ip_address);
                setVal('edit_network', serveur.network);
            }

            // 5. Open Modal
            document.getElementById('editModal').style.display = 'block';
            
            // Close dropdown
            document.querySelectorAll('.dropdown-menu').forEach(el => el.style.display = 'none');

        } catch (error) {
            console.error("Error opening modal:", error);
            alert("Une erreur est survenue lors de l'ouverture du formulaire d'édition.");
        }
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    // Close modals on outside click
    window.onclick = function(event) {
        let createModal = document.getElementById('createModal');
        let editModal = document.getElementById('editModal');
        
        if (event.target == createModal) {
            createModal.style.display = "none";
        }
        if (event.target == editModal) {
            editModal.style.display = "none";
        }
    }
</script>
@endsection