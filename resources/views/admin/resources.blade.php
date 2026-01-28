@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 style="font-size: 1.8rem; font-weight: 700;">Catalogue des Ressources</h1>
        <button class="btn btn-primary" onclick="openAddModal()">
            <i class="fas fa-plus" style="margin-right: 8px;"></i> Ajouter Ressource
        </button>
    </div>

    <!-- Filter Section -->
    <div class="card mb-3" style="padding: 1rem; margin-bottom: 1.5rem;">
        <form action="{{ route('admin.resources') }}" method="GET" class="flex gap-4 items-end">
            
            <!-- Type Filter -->
            <div style="flex: 1; max-width: 200px;">
                <label style="display:block; font-size: 0.8rem; color: var(--text-secondary); margin-bottom: 0.3rem;">Type</label>
                <select name="type" style="width: 100%; padding: 0.5rem; border-radius: 8px; background: var(--bg-app); border: 1px solid var(--border); color: var(--text-primary);">
                    <option value="">Tous les types</option>
                    <option value="serveur" {{ request('type') == 'serveur' ? 'selected' : '' }}>Serveur</option>
                    <option value="machine_virtuelle" {{ request('type') == 'machine_virtuelle' ? 'selected' : '' }}>Machine Virtuelle</option>
                    <option value="equipement_reseau" {{ request('type') == 'equipement_reseau' ? 'selected' : '' }}>Équipement Réseau</option>
                    <option value="baie_stockage" {{ request('type') == 'baie_stockage' ? 'selected' : '' }}>Baie de Stockage</option>
                </select>
            </div>

            <!-- Status Filter -->
            <div style="flex: 1; max-width: 200px;">
                <label style="display:block; font-size: 0.8rem; color: var(--text-secondary); margin-bottom: 0.3rem;">Statut</label>
                <select name="status" style="width: 100%; padding: 0.5rem; border-radius: 8px; background: var(--bg-app); border: 1px solid var(--border); color: var(--text-primary);">
                    <option value="">Tous les statuts</option>
                    <option value="disponible" {{ request('status') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                    <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="reserve" {{ request('status') == 'reserve' ? 'selected' : '' }}>Réservé</option>
                </select>
            </div>

            <!-- Actions -->
            <div class="flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-filter"></i> Filtrer
                </button>
                
                @if(request('type') || request('status'))
                    <a href="{{ route('admin.resources') }}" class="btn btn-outline btn-sm" style="display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Type</th>
                    <th>Responsable</th>
                    <th>Ajouté Par</th>
                    <th>Date Ajout</th>
                    <th>Statut</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($resources as $resource)
                <tr>
                    <td>
                        <button onclick="openResourceDetails({{ json_encode($resource) }})" 
                                class="text-primary hover:underline font-bold" 
                                style="background:none; border:none; padding:0; cursor:pointer; color: var(--primary);">
                            {{ $resource->name }}
                        </button>
                    </td>
                    <td>{{ $resource->type }}</td>
                    <td>
                        {{ $resource->manager ? $resource->manager->name : 'Non assigné' }}
                    </td>
                    <td>
                        @if($resource->creator)
                            <div style="font-size:0.9rem;">{{ $resource->creator->name }}</div>
                            <div style="font-size:0.75rem; color:var(--text-secondary);">{{ $resource->creator->role ?? 'Admin' }}</div>
                        @else
                            <span style="color:var(--text-secondary);">Système</span>
                        @endif
                    </td>
                    <td>
                        <span style="font-size: 0.85rem; color: var(--text-secondary);">
                            {{ $resource->created_at->format('d/m/Y') }}<br>
                            {{ $resource->created_at->format('H:i') }}
                        </span>
                    </td>
                    <td>
                        @if($resource->status === 'disponible')
                            <span class="badge bg-success">Disponible</span>
                        @elseif($resource->status === 'maintenance')
                            <span class="badge bg-warning">Maintenance</span>
                        @else
                            <span class="badge bg-danger">{{ $resource->status }}</span>
                        @endif
                    </td>
                    <td class="flex items-center gap-2" style="justify-content: flex-end;">
                        <!-- Maintenance Toggle -->
                        @if($resource->status === 'maintenance')
                            <form action="{{ route('admin.resources.maintenance', $resource->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline" title="Terminer Maintenance" style="color: #34d399; border-color: rgba(52, 211, 153, 0.3);">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                        @else
                            <button onclick="openMaintenanceModal('{{ $resource->id }}', '{{ $resource->name }}')" class="btn btn-sm btn-outline" title="Mettre en Maintenance" style="color: #fbbf24; border-color: rgba(251, 191, 36, 0.3);">
                                <i class="fas fa-tools"></i>
                            </button>
                        @endif

                        <!-- Delete Resource -->
                        <form action="{{ route('admin.resources.destroy', $resource->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette ressource ?');" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline" title="Supprimer" style="color: #f87171; border-color: rgba(248, 113, 113, 0.3);">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 2rem; color: var(--text-muted);">Aucune ressource trouvée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <!-- Resource Count Footer -->
        <div style="margin-top: 1rem; text-align: left; color: var(--text-secondary); font-size: 0.9rem; padding-left: 0.5rem;">
            Total ressources : <strong>{{ $resources->count() }}</strong>
        </div>
    </div>

    <!-- Modal Ajouter Ressource -->
    <div id="addResourceModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(5px); animation: fadeIn 0.2s; padding: 1rem;">
        <div class="card" style="width: 100%; max-width: 500px; max-height: 90vh; overflow-y: auto; background: #1e293b; border: 1px solid rgba(255,255,255,0.1);">
            <div class="flex justify-between items-center mb-3">
                <h2>Ajouter une Ressource</h2>
                <button type="button" onclick="closeAddModal()" style="background:none; border:none; color:var(--text-secondary); font-size:1.5rem; cursor:pointer;">&times;</button>
            </div>

            <form action="{{ route('admin.resources.store') }}" method="POST">
                @csrf
                <div class="mb-3" style="margin-bottom: 1rem;">
                    <label style="display:block; margin-bottom: 0.5rem; color: var(--text-secondary);">Nom de la ressource</label>
                    <input type="text" name="name" required placeholder="Ex: Serveur Alpha 01" style="width: 100%; padding: 0.75rem; border-radius: var(--radius-sm); background: var(--bg-app); border: 1px solid var(--border); color: var(--text-primary);">
                </div>

                <div class="mb-3" style="margin-bottom: 1rem;">
                    <label style="display:block; margin-bottom: 0.5rem; color: var(--text-secondary);">Type</label>
                    <select name="type" id="addTypeSelect" required style="width: 100%; padding: 0.75rem; border-radius: var(--radius-sm); background: var(--bg-app); border: 1px solid var(--border); color: var(--text-primary);" onchange="updateAddFields()">
                        <option value="serveur">Serveur</option>
                        <option value="machine_virtuelle">Machine Virtuelle</option>
                        <option value="equipement_reseau">Équipement Réseau</option>
                        <option value="baie_stockage">Baie de Stockage</option>
                    </select>
                </div>

                <!-- Dynamic Fields for Add -->
                <div id="addDynamicFields" style="margin-bottom: 1rem; padding: 1rem; border: 1px solid var(--border); border-radius: var(--radius-sm); background: rgba(255,255,255,0.02);">
                    <!-- Fields injected by JS -->
                </div>

                <div class="mb-3" style="margin-bottom: 2rem;">
                    <label style="display:block; margin-bottom: 0.5rem; color: var(--text-secondary);">Responsable (Manager)</label>
                    <select name="manager_id" style="width: 100%; padding: 0.75rem; border-radius: var(--radius-sm); background: var(--bg-app); border: 1px solid var(--border); color: var(--text-primary);">
                        <option value="">-- Non assigné --</option>
                        @foreach(\App\Models\User::all() as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role ?? 'N/A' }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-between">
                    <button type="button" onclick="closeAddModal()" class="btn btn-outline" style="color: #94a3b8; border-color: #475569;">Annuler</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>

    <div id="maintenanceModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center; animation: fadeIn 0.2s;">
        <div class="card" style="width: 100%; max-width: 500px; margin: 2rem;">
            <div class="flex justify-between items-center mb-3">
                <h2 id="maintModalTitle">Maintenance</h2>
                <button type="button" onclick="closeMaintModal()" style="background:none; border:none; color:var(--text-secondary); font-size:1.5rem; cursor:pointer;">&times;</button>
            </div>

            <form id="maintForm" action="" method="POST">
                @csrf
                <p class="mb-3" style="color: var(--text-primary);">Voulez-vous mettre cette ressource en maintenance ?</p>
                
                <div class="mb-3" style="margin-bottom: 1.5rem;">
                    <label style="display:block; margin-bottom: 0.5rem; color: var(--text-secondary);">Raison de la maintenance</label>
                    <input type="text" name="reason" id="maintReason" placeholder="Ex: Réparation disque dur..." style="width: 100%; padding: 0.75rem; border-radius: var(--radius-sm); background: var(--bg-app); border: 1px solid var(--border); color: var(--text-primary);">
                </div>

                <div class="flex flex-col gap-2">
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Valider la Maintenance</button>
                    
                    <div style="display: flex; align-items: center; gap: 10px; margin-top: 10px;">
                        <span style="height: 1px; background: var(--border); flex: 1;"></span>
                        <span style="color: var(--text-secondary); font-size: 0.8rem;">OU</span>
                        <span style="height: 1px; background: var(--border); flex: 1;"></span>
                    </div>

                    <button type="button" onclick="submitQuickMaint()" class="btn btn-outline" style="width: 100%; color: #fbbf24; border-color: rgba(251, 191, 36, 0.3);">
                        <i class="fas fa-bolt"></i> Maintenance Rapide
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('addResourceModal').style.display = 'flex';
        }
        function closeAddModal() {
            document.getElementById('addResourceModal').style.display = 'none';
        }

        function openMaintenanceModal(id, name) {
            document.getElementById('maintenanceModal').style.display = 'flex';
            document.getElementById('maintModalTitle').innerText = 'Maintenance : ' + name;
            document.getElementById('maintForm').action = '/admin/resources/' + id + '/maintenance';
            document.getElementById('maintReason').value = ''; // Reset
        }

        function closeMaintModal() {
            document.getElementById('maintenanceModal').style.display = 'none';
        }

        function submitQuickMaint() {
            document.getElementById('maintReason').value = 'Maintenance Rapide';
            document.getElementById('maintForm').submit();
        }
    </script>
    @include('admin.resource_modals')
    <script>
        function updateAddFields() {
            const type = document.getElementById('addTypeSelect').value;
            const container = document.getElementById('addDynamicFields');
            container.innerHTML = '';

            const createField = (label, name, placeholder = '', type = 'text') => {
                return `
                    <div class="mb-3" style="margin-bottom: 1rem;">
                        <label style="display:block; margin-bottom: 0.5rem; color: var(--text-secondary); font-size:0.9rem;">${label}</label>
                        <input type="${type}" name="${name}" placeholder="${placeholder}" style="width: 100%; padding: 0.75rem; border-radius: var(--radius-sm); background: var(--bg-app); border: 1px solid var(--border); color: var(--text-primary);">
                    </div>
                `;
            };

            if (type === 'serveur') {
                container.innerHTML += createField('Emplacement', 'emplacement', 'Ex: Baie A, Rack 2');
                container.innerHTML += createField('CPU', 'cpu', 'Ex: 16 (Coeurs)', 'number');
                container.innerHTML += createField('RAM', 'ram', 'Ex: 64 (GB)', 'number');
                container.innerHTML += createField('Stockage', 'stockage', 'Ex: 2048 (GB)', 'number');
                container.innerHTML += createField('OS', 'os', 'Ex: Ubuntu 22.04');
                container.innerHTML += createField('Modèle', 'modele', 'Ex: Dell PowerEdge');
                container.innerHTML += createField('Numéro de Série', 'numero_serie', 'Ex: SN123456');
            } else if (type === 'machine_virtuelle') {
                container.innerHTML += createField('CPU', 'cpu', 'Ex: 4 (vCPU)', 'number');
                container.innerHTML += createField('RAM', 'ram', 'Ex: 16 (GB)', 'number');
                container.innerHTML += createField('Stockage', 'stockage', 'Ex: 100 (GB)', 'number');
                container.innerHTML += createField('OS', 'os', 'Ex: CentOS 8');
                container.innerHTML += createField('Bande Passante', 'bande_passante', 'Ex: 1000 (Mbps)', 'number');
                container.innerHTML += createField('Hyperviseur', 'hyperviseur', 'Ex: VMware ESXi');
                container.innerHTML += createField('Adresse IP', 'adresse_ip', 'Ex: 192.168.1.50');
            } else if (type === 'equipement_reseau') {
                container.innerHTML += createField('Emplacement', 'emplacement', 'Ex: Salle Serveur 1');
                container.innerHTML += createField('Type Équipement', 'type_equipement', 'Ex: Switch');
                container.innerHTML += createField('Modèle', 'modele', 'Ex: Cisco 2960');
                container.innerHTML += createField('Numéro de Ports', 'numero_ports', 'Ex: 24', 'number');
                container.innerHTML += createField('Bande Passante', 'bande_passante', 'Ex: 10000 (Mbps)', 'number');
            } else if (type === 'baie_stockage') {
                container.innerHTML += createField('Emplacement', 'emplacement', 'Ex: Zone B');
                container.innerHTML += createField('Type Stockage', 'type_stockage', 'Ex: NAS');
                container.innerHTML += createField('Capacité Totale', 'capacite', 'Ex: 100000 (GB)', 'number');
                container.innerHTML += createField('Système de Fichiers', 'systeme_fichiers', 'Ex: ZFS');
            }
        }

        // Initialize on load
        document.addEventListener('DOMContentLoaded', updateAddFields);
    </script>
@endsection
