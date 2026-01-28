@extends('layouts.responsable')

@section('content')
<link rel="stylesheet" href="{{ asset('css/app.css') }}">

<div class="main-container">
    <div class="header" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1>Gestion des ressources</h1>
            <p style="color: var(--text-muted);">Administrez les ressources du Data Center</p>
        </div>
        <button class="btn-save-dark" onclick="openCreateModal()">+ Nouvelle ressource</button>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Ressource</th>
                    <th>Type</th>
                    <th>Emplacement</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($resources as $r)
                <tr>
                    <td>
                        <strong>{{ $r->name }}</strong><br>
                        <small style="color: var(--text-muted);">{{ $r->serveur->ip_address ?? '192.168.1.1' }}</small>
                    </td>
                    <td>{{ $r->type }}</td>
                    <td>{{ $r->location ?? 'Salle A, Baie 1' }}</td>
                    <td><span class="badge {{ $r->status }}">{{ $r->status }}</span></td>
                    <td style="white-space: nowrap; width: 100px;">
                        <div style="display: flex; gap: 15px; align-items: center;">
                            <a href="javascript:void(0)"
                                class="edit-btn"
                                style="color: #00acc1; font-size: 1.1rem; transition: 0.3s;"
                                data-resource='@json($r)'
                                data-serveur='@json($r->serveur)'
                                onclick="handleEditClick(this)"
                                title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('resource.delete', $r->id) }}" method="POST" onsubmit="return confirm('Supprimer cette ressource ?');" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    style="background: none; border: none; color: #ff5252; font-size: 1.1rem; cursor: pointer; padding: 0; transition: 0.3s;"
                                    title="Supprimer">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>

<div id="createModal" class="modal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px);">
    <div class="modal-content" style="background-color: #ffffff; margin: 2% auto; padding: 0; border-radius: 20px; width: 800px; box-shadow: 0 20px 25px rgba(0,0,0,0.1); overflow: hidden; font-family: sans-serif;">

        <div style="padding: 20px 30px; border-bottom: 1px solid #f1f5f9;">
            <h2 style="margin: 0; font-size: 1.25rem; color: #1e293b;">Ajouter une Ressource</h2>
        </div>

        <form action="{{ route('resource.store') }}" method="POST" style="padding: 30px;">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">

                <div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 13px; color: #64748b; margin-bottom: 5px; font-weight: 500;">Nom *</label>
                        <input type="text" name="name" placeholder="ex: serveur i30" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; box-sizing: border-box;" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 13px; color: #64748b; margin-bottom: 5px; font-weight: 500;">CPU</label>
                        <input type="text" name="cpu" placeholder="ex: Intel Xeon 16 cores" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; box-sizing: border-box;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 13px; color: #64748b; margin-bottom: 5px; font-weight: 500;">Stockage</label>
                        <input type="text" name="stockage" placeholder="ex: 2TB SSD" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; box-sizing: border-box;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 13px; color: #64748b; margin-bottom: 5px; font-weight: 500;">Système d'exploitation</label>
                        <input type="text" name="os" placeholder="ex: Ubuntu 22.04" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; box-sizing: border-box;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 13px; color: #64748b; margin-bottom: 5px; font-weight: 500;">Adresse IP</label>
                        <input type="text" name="ip_address" placeholder="ex: 192.168.1.100" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; box-sizing: border-box;">
                    </div>
                </div>

                <div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 13px; color: #64748b; margin-bottom: 5px; font-weight: 500;">Catégorie *</label>
                        <select name="type" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; background: white; box-sizing: border-box;">
                            <option value="serveur">Serveur Physique</option>
                            <option value="machine_virtuelle">Machine Virtuelle</option>
                            <option value="serveur">Baies de Stockage</option>
                            <option value="serveur">Equipements Réseau</option>
                             
                        </select>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 13px; color: #64748b; margin-bottom: 5px; font-weight: 500;">RAM</label>
                        <input type="text" name="ram" placeholder="ex: 64 GB" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; box-sizing: border-box;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 13px; color: #64748b; margin-bottom: 5px; font-weight: 500;">Réseau</label>
                        <input type="text" name="network" placeholder="ex: 10 Gbps" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; box-sizing: border-box;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 13px; color: #64748b; margin-bottom: 5px; font-weight: 500;">Emplacement</label>
                        <input type="text" name="location" placeholder="ex: Rack A-12" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; box-sizing: border-box;">
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; font-size: 13px; color: #64748b; margin-bottom: 5px; font-weight: 500;">Statut</label>
                        <select name="status" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; background: white; box-sizing: border-box;">
                            <option value="disponible">Disponible</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="reserve">Réservé</option>
                        </select>
                    </div>
                </div>
            </div>

            <div style="margin-top: 10px;">
                <label style="display: block; font-size: 13px; color: #64748b; margin-bottom: 5px; font-weight: 500;">Spécifications détaillées</label>
                <textarea name="description" rows="4" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; box-sizing: border-box; resize: vertical;"></textarea>
            </div>

            <div style="margin-top: 30px; display: flex; justify-content: flex-end; gap: 12px;">
                <button type="button" onclick="closeCreateModal()" style="padding: 10px 25px; background: white; border: 1px solid #e2e8f0; border-radius: 10px; color: #64748b; cursor: pointer;">Annuler</button>
                <button type="submit" style="padding: 10px 30px; background: #00acc1; border: none; border-radius: 10px; color: white; cursor: pointer; font-weight: 600;">Créer</button>
            </div>
        </form>
    </div>
</div>
<div id="editModal" class="modal" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px);">
    <div class="modal-content" style="background-color: #ffffff; margin: 2% auto; padding: 0; border-radius: 20px; width: 850px; box-shadow: 0 20px 25px rgba(0,0,0,0.1); max-height: 90vh; display: flex; flex-direction: column; overflow: hidden; font-family: sans-serif;">

        <div style="padding: 20px 30px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
            <h2 style="margin: 0; font-size: 1.25rem; color: #1e293b; font-weight: 600;">Modifier la Ressource</h2>
            <button type="button" onclick="closeEditModal()" style="background:none; border:none; font-size:24px; cursor:pointer; color:#94a3b8;">&times;</button>
        </div>

        <form id="editForm" method="POST" style="overflow-y: auto; flex-grow: 1;">
            @csrf
            @method('PUT')

            <div style="padding: 30px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; font-size: 13px; color: #64748b; margin-bottom: 5px; font-weight: 500;">Nom *</label>
                            <input type="text" id="edit_name" name="name" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;" required>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; font-size: 13px; color: #64748b; margin-bottom: 5px; font-weight: 500;">CPU</label>
                            <input type="text" id="edit_cpu" name="cpu" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; font-size: 13px; color: #64748b; margin-bottom: 5px; font-weight: 500;">Stockage</label>
                            <input type="text" id="edit_stockage" name="stockage" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; font-size: 13px; color: #64748b; margin-bottom: 5px; font-weight: 500;">Système d'exploitation</label>
                            <input type="text" id="edit_os" name="os" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; font-size: 13px; color: #64748b; margin-bottom: 5px; font-weight: 500;">Adresse IP</label>
                            <input type="text" id="edit_ip_address" name="ip_address" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                        </div>
                    </div>

                    <div>
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; font-size: 13px; color: #64748b; margin-bottom: 5px; font-weight: 500;">Catégorie *</label>
                            <select id="edit_type" name="type" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; background: white;">
                                <option value="serveur">Serveur Physique</option>
                                <option value="machine_virtuelle">Machine Virtuelle</option>
                            </select>
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; font-size: 13px; color: #64748b; margin-bottom: 5px; font-weight: 500;">RAM</label>
                            <input type="text" id="edit_ram" name="ram" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; font-size: 13px; color: #64748b; margin-bottom: 5px; font-weight: 500;">Réseau</label>
                            <input type="text" id="edit_network" name="network" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; font-size: 13px; color: #64748b; margin-bottom: 5px; font-weight: 500;">Emplacement</label>
                            <input type="text" id="edit_location" name="location" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px;">
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; font-size: 13px; color: #64748b; margin-bottom: 5px; font-weight: 500;">Statut</label>
                            <select id="edit_status" name="status" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; background: white;">
                                <option value="disponible">Disponible</option>
                                <option value="maintenance">Maintenance</option>
                                <option value="reserve">Réservé</option>

                            </select>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 10px;">
                    <label style="display: block; font-size: 13px; color: #64748b; margin-bottom: 5px; font-weight: 500;">Spécifications détaillées</label>
                    <textarea id="edit_description" name="description" rows="3" style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 8px; resize: vertical;"></textarea>
                </div>

                <div style="margin-top: 30px; display: flex; justify-content: flex-end; gap: 12px; padding-bottom: 10px;">
                    <button type="button" onclick="closeEditModal()" style="padding: 10px 25px; background: white; border: 1px solid #e2e8f0; border-radius: 10px; color: #64748b; cursor: pointer;">Annuler</button>
                    <button type="submit" style="padding: 10px 30px; background: #00acc1; border: none; border-radius: 10px; color: white; cursor: pointer; font-weight: 600;">Enregistrer les modifications</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
<script>
    function openCreateModal() {
        document.getElementById('createModal').style.display = 'block';
    }

    function closeCreateModal() {
        document.getElementById('createModal').style.display = 'none';
    }

    function handleEditClick(element) {
        try {
            // 1. Parse data
            const resource = JSON.parse(element.getAttribute('data-resource'));
            const serveur = JSON.parse(element.getAttribute('data-serveur'));
            console.log("serveur data :"+resource.status)

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

            // 4. Fill Server Fields (Now matching the updated IDs above)
            if (serveur) {
                setVal('edit_cpu', serveur.cpu);
                setVal('edit_ram', serveur.ram);
                setVal('edit_stockage', serveur.stockage);
                setVal('edit_os', serveur.os);
                setVal('edit_ip_address', serveur.ip_address); // Matches updated ID
                setVal('edit_network', serveur.network); // Matches new field
            }

            // 5. Open Modal
            document.getElementById('editModal').style.display = 'block';

        } catch (error) {
            console.error("Error opening modal:", error);
            alert("Check Console (F12) - JavaScript error detected.");
        }
    }

    // --- EDIT MODAL ---
    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    // Fermer si on clique en dehors de la boîte blanche
    window.onclick = function(event) {
        let modal = document.getElementById('createModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
@endsection