// Gestion des menus 3 points
function toggleMenu(id) {
    const menu = document.getElementById(id);
    document.querySelectorAll('.dropdown-content').forEach(m => {
        if(m !== menu) m.style.display = 'none';
    });
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
}

// Modale Ajout
function openCreateModal() {
    document.getElementById('createModal').style.display = 'block';
}

function closeCreateModal() {
    document.getElementById('createModal').style.display = 'none';
}

// Modale Edition (Capture 228/229)
function openEditModal(resource) {
    document.getElementById('edit_name').value = resource.name;
    document.getElementById('edit_type').value = resource.type;
    
    // Si la ressource a des détails serveurs
    if(resource.serveur) {
        document.getElementById('edit_cpu').value = resource.serveur.cpu || '';
        document.getElementById('edit_ram').value = resource.serveur.ram || '';
        document.getElementById('edit_ip').value = resource.serveur.ip_address || '';
        document.getElementById('edit_os').value = resource.serveur.os || '';
    }

    const form = document.getElementById('editForm');
    form.action = `/responsable/resource/${resource.id}/update`;
    document.getElementById('editModal').style.display = 'block';
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

// Fermer les modales si on clique à l'extérieur
window.onclick = function(event) {
    if (event.target.className === 'modal') {
        event.target.style.display = "none";
    }
}

function handleEditClick(element) {
    // On récupère les données stockées dans l'attribut data-resource
    const resourceData = JSON.parse(element.getAttribute('data-resource'));
    // On appelle la fonction d'ouverture que nous avons déjà créée
    openEditModal(resourceData);
}