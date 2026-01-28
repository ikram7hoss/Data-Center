<!-- Resource Details Modal -->
<div id="resourceDetailsModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(5px); animation: fadeIn 0.2s; padding: 1rem;">
    <div class="card" style="width: 100%; max-width: 600px; max-height: 90vh; overflow-y: auto; background: #1e293b; border: 1px solid rgba(255,255,255,0.1);">
        <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 1rem;">
            <h2 class="modal-title" id="detailsModalTitle" style="font-size: 1.5rem; margin: 0; color: #fff;">Détails de la Ressource</h2>
            <button class="modal-close" onclick="closeDetailsModal()" style="background: none; border: none; color: #94a3b8; font-size: 1.5rem; cursor: pointer;">&times;</button>
        </div>
        <form id="resourceDetailsForm" method="POST">
            @csrf
            
            <div class="modal-body">
                <!-- Common Fields -->
                <div class="form-group mb-4">
                    <label class="form-label" style="display: block; margin-bottom: 0.5rem; color: #94a3b8;">Nom de la Ressource</label>
                    <input type="text" name="name" id="detailName" class="form-control" required style="width: 100%; padding: 0.75rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;">
                </div>

                <div class="form-group mb-4">
                    <label class="form-label" style="display: block; margin-bottom: 0.5rem; color: #94a3b8;">Type</label>
                    <input type="text" id="detailType" class="form-control" readonly disabled style="width: 100%; padding: 0.75rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff; opacity: 0.7;">
                </div>

                <!-- Dynamic Fields Container -->
                <div id="dynamicFields" style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1rem; margin-top: 1rem;">
                    <!-- JS will inject fields here -->
                </div>
            </div>

            <div class="modal-footer" style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1);">
                <button type="button" class="btn btn-outline" onclick="closeDetailsModal()" style="padding: 0.5rem 1rem; border-radius: 6px; border: 1px solid #475569; color: #cbd5e1; background: transparent; cursor: pointer;">Annuler</button>
                <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem; border-radius: 6px; background: #3b82f6; color: white; border: none; cursor: pointer;">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openResourceDetails(resource) {
        const modal = document.getElementById('resourceDetailsModal');
        const form = document.getElementById('resourceDetailsForm');
        const dynamicFields = document.getElementById('dynamicFields');
        
        // Prepare Form Action
        form.action = `/admin/resources/${resource.id}/update-details`;

        // Fill Basic Info
        document.getElementById('detailName').value = resource.name;
        document.getElementById('detailType').value = resource.type;

        // Clear previous dynamic fields
        dynamicFields.innerHTML = '';
        
        // Helper to create input
        const createField = (label, name, value, type = 'text') => {
            return `
                <div class="form-group mb-3">
                    <label class="form-label" style="display: block; margin-bottom: 0.5rem; color: #94a3b8; font-size:0.9rem;">${label}</label>
                    <input type="${type}" name="${name}" value="${value || ''}" class="form-control" style="width: 100%; padding: 0.75rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;">
                </div>
            `;
        };

        // Inject fields based on type
        let details = null;
        if (resource.type === 'serveur') details = resource.serveur;
        else if (resource.type === 'machine_virtuelle') details = resource.machine_virtuelle;
        else if (resource.type === 'equipement_reseau') details = resource.equipement_reseau;
        else if (resource.type === 'baie_stockage') details = resource.baie_stockage;

        details = details || {}; // Fallback if null

        if (resource.type === 'serveur' || resource.type === 'Serveur') { // Handle loose typing
            dynamicFields.innerHTML += createField('CPU', 'cpu', details.cpu);
            dynamicFields.innerHTML += createField('RAM', 'ram', details.ram);
            dynamicFields.innerHTML += createField('Stockage', 'stockage', details.stockage);
            dynamicFields.innerHTML += createField('OS', 'os', details.os);
            dynamicFields.innerHTML += createField('Modèle', 'modele', details.modele);
            dynamicFields.innerHTML += createField('Numéro de Série', 'numero_serie', details.numero_serie);
        } 
        else if (resource.type === 'machine_virtuelle') {
            dynamicFields.innerHTML += createField('CPU', 'cpu', details.cpu);
            dynamicFields.innerHTML += createField('RAM', 'ram', details.ram);
            dynamicFields.innerHTML += createField('Stockage', 'stockage', details.stockage);
            dynamicFields.innerHTML += createField('OS', 'os', details.os);
            dynamicFields.innerHTML += createField('Hyperviseur', 'hyperviseur', details.hyperviseur);
            dynamicFields.innerHTML += createField('Adresse IP', 'adresse_ip', details.adresse_ip);
        }
        else if (resource.type === 'equipement_reseau') {
            dynamicFields.innerHTML += createField('Type Équipement', 'type_equipement', details.type_equipement);
            dynamicFields.innerHTML += createField('Modèle', 'modele', details.modele);
            dynamicFields.innerHTML += createField('Numéro de Ports', 'numero_ports', details.numero_ports, 'number');
            dynamicFields.innerHTML += createField('Bande Passante', 'bande_passante', details.bande_passante);
        }
        else if (resource.type === 'baie_stockage') {
            dynamicFields.innerHTML += createField('Type Stockage', 'type_stockage', details.type_stockage);
            dynamicFields.innerHTML += createField('Capacité Totale', 'capacite', details.capacite);
            dynamicFields.innerHTML += createField('Système de Fichiers', 'systeme_fichiers', details.systeme_fichiers);
        }

        modal.style.display = 'flex';
    }

    function closeDetailsModal() {
        document.getElementById('resourceDetailsModal').style.display = 'none';
    }

    // Close on click outside
    window.onclick = function(event) {
        const modal = document.getElementById('resourceDetailsModal');
        if (event.target == modal) {
            closeDetailsModal();
        }
    }
</script>
