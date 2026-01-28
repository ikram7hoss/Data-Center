@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 style="font-size: 1.8rem; font-weight: 700;">Gestion des Utilisateurs</h1>
    </div>

    <!-- Filter Section -->
    <div class="card mb-3" style="padding: 1rem; margin-bottom: 1.5rem;">
        <form action="{{ route('admin.users') }}" method="GET" class="flex gap-4 items-end">
            
            <!-- Role Filter -->
            <div style="flex: 1; max-width: 200px;">
                <label style="display:block; font-size: 0.8rem; color: var(--text-secondary); margin-bottom: 0.3rem;">Rôle</label>
                <select name="role" style="width: 100%; padding: 0.5rem; border-radius: 8px; background: var(--bg-app); border: 1px solid var(--border); color: var(--text-primary);">
                    <option value="">Tous les rôles</option>
                    @foreach($allRoles as $role)
                        <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div style="flex: 1; max-width: 200px;">
                <label style="display:block; font-size: 0.8rem; color: var(--text-secondary); margin-bottom: 0.3rem;">Statut</label>
                <select name="status" style="width: 100%; padding: 0.5rem; border-radius: 8px; background: var(--bg-app); border: 1px solid var(--border); color: var(--text-primary);">
                    <option value="">Tous les statuts</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actif</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactif</option>
                </select>
            </div>

            <!-- Actions -->
            <div class="flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-filter"></i> Filtrer
                </button>
                
                @if(request('role') || request('status'))
                    <a href="{{ route('admin.users') }}" class="btn btn-outline btn-sm" style="display: flex; align-items: center; justify-content: center;">
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
                    <th>Email</th>
                    <th>Rôles</th>
                    <th>Permissions</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                        <div style="font-weight: 600;">{{ $user->name }}</div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <div class="flex items-center gap-1" style="flex-wrap: wrap;">
                            @forelse($user->roles as $role)
                                <span class="badge bg-primary" style="background: rgba(59, 130, 246, 0.2); color: #60a5fa; border: 1px solid rgba(59,130,246,0.3);">
                                    {{ $role->name }}
                                </span>
                            @empty
                                <span class="badge badge-neutral">{{ $user->type }}</span> <!-- Legacy fallback -->
                            @endforelse
                        </div>
                    </td>
                    <td>
                        <div style="font-size: 0.8rem; color: var(--text-secondary); max-width: 250px;">
                            @php
                                $perms = $user->getEffectivePermissions()->pluck('name');
                            @endphp
                            @if($perms->isNotEmpty())
                                {{ $perms->take(5)->implode(', ') }}
                                @if($perms->count() > 5) ... @endif
                            @else
                                <span style="opacity: 0.5;">Aucune</span>
                            @endif
                            
                            <!-- Edit Trigger for this specific column -->
                            <button onclick="openRoleModal(
                                        '{{ $user->id }}', 
                                        '{{ $user->name }}', 
                                        {{ json_encode($user->roles->pluck('id')) }}, 
                                        {{ json_encode($user->getGrantedPermissions()->pluck('id')) }},
                                        {{ json_encode($user->getForbiddenPermissions()->pluck('id')) }},
                                        'permissions_only'
                                    )" 
                                    class="btn btn-sm btn-ghost" 
                                    style="padding: 2px 6px; margin-left: 5px; color: var(--text-secondary);" 
                                    title="Modifier les exceptions">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </td>
                    <td>
                        @if($user->is_active)
                            <span class="badge bg-success">Actif</span>
                        @else
                            <span class="badge bg-danger">Inactif</span>
                        @endif
                    </td>
                    <td class="flex items-center gap-2">
                        <!-- Manage Roles Button -->
                        <button onclick="openRoleModal(
                                    '{{ $user->id }}', 
                                    '{{ $user->name }}', 
                                    {{ json_encode($user->roles->pluck('id')) }}, 
                                    {{ json_encode($user->getGrantedPermissions()->pluck('id')) }},
                                    {{ json_encode($user->getForbiddenPermissions()->pluck('id')) }},
                                    'role_only'
                                )" 
                                class="btn btn-sm btn-outline" 
                                title="Changer le Rôle (Status)" 
                                style="color: #a78bfa; border-color: rgba(167, 139, 250, 0.3);">
                            <i class="fas fa-user-shield"></i>
                        </button>

                        <form action="{{ route('admin.users.toggle-status', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $user->is_active ? 'btn-danger' : 'btn-outline' }}">
                                <i class="fas fa-power-off"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal Manage Roles -->
    <div id="roleModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center; animation: fadeIn 0.2s; padding: 1rem;">
        <div class="card" style="width: 95%; max-width: 1200px; max-height: 90vh; overflow-y: auto; overflow-x: auto;">
            <div class="flex justify-between items-center mb-3">
                <h2 id="roleModalTitle" style="font-size: 1.5rem;">Gérer les Rôles et Permissions</h2>
                <button type="button" onclick="closeRoleModal()" style="background:none; border:none; color:var(--text-secondary); font-size:2rem; cursor:pointer; line-height: 1;">&times;</button>
            </div>

            <form id="roleForm" action="" method="POST">
                @csrf
                <div class="grid-2-responsive" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; align-items: start;">
                    <!-- Column 1: Roles -->
                    <div id="roleColumnContent">
                        <h4 style="margin-bottom: 1rem; color: var(--text-primary); border-bottom: 1px solid var(--border); padding-bottom: 0.5rem; font-size: 1.1rem;">
                            1. Rôle 
                            <span style="display:block; font-size: 0.8rem; color: var(--text-secondary); font-weight: normal;">Détermine les permissions par défaut</span>
                        </h4>
                        <div class="flex flex-col gap-2">
                        @foreach($allRoles as $role)
                            <label style="display: flex; align-items: center; gap: 0.75rem; padding: 1rem; border: 1px solid var(--border); border-radius: var(--radius-sm); cursor: pointer; transition: 0.2s; font-size: 1rem;" onclick="updatePermissionsFromRole({{ $role->id }})">
                                <input type="radio" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}" style="accent-color: var(--accent); transform: scale(1.2);">
                                <span style="font-weight: 600;">{{ $role->name }}</span>
                            </label>
                        @endforeach
                        </div>
                    </div>

                    <!-- Column 2: Effective Permissions -->
                    <div id="permissionColumnContent">
                        <h4 style="margin-bottom: 1rem; color: var(--text-primary); border-bottom: 1px solid var(--border); padding-bottom: 0.5rem; font-size: 1.1rem;">
                            2. Exceptions
                            <span style="display:block; font-size: 0.8rem; color: var(--text-secondary); font-weight: normal;">Cochez pour AJOUTER, Décochez pour INTERDIRE</span>
                        </h4>
                        
                        <div class="flex flex-col gap-1" style="max-height: 500px; overflow-y: auto; padding-right: 5px; background: #f8fafc; padding: 1rem; border-radius: 0.5rem; border: 1px solid var(--border);">
                            @foreach($allPermissions as $perm)
                                <label style="display: flex; align-items: center; gap: 0.75rem; font-size: 1rem; color: var(--text-secondary); cursor: pointer; padding: 4px 0;">
                                    <input type="checkbox" name="permissions[]" value="{{ $perm->id }}" id="perm_{{ $perm->id }}" style="accent-color: #34d399; transform: scale(1.2);">
                                    {{ $perm->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex justify-between mt-4">
                    <button type="button" onclick="closeRoleModal()" class="btn btn-outline" style="color: #94a3b8; border-color: #475569;">Annuler</button>
                    <button type="submit" class="btn btn-primary" title="Sauvegarder les changements">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Map of Role ID => [Permission IDs]
        const rolePermissionsMap = @json($rolesWithPermissions);

        function openRoleModal(userId, userName, currentRoles = [], grantedPermissionIds = [], forbiddenPermissionIds = [], mode = 'full') {
            document.getElementById('roleModal').style.display = 'flex';
            document.getElementById('roleForm').action = '/admin/users/' + userId + '/update-roles';
            
            // Reset form
            document.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
            document.querySelectorAll('input[type="radio"]').forEach(rb => rb.checked = false);

            // 1. Select Role
            let currentRoleId = null;
            if (currentRoles && currentRoles.length > 0) {
                currentRoleId = currentRoles[0]; // Assuming single role
                const rb = document.getElementById('role_' + currentRoleId);
                if (rb) rb.checked = true;
            }

            // 2. Select Permissions from Role (Visual cue)
            if (currentRoleId && rolePermissionsMap[currentRoleId]) {
                 rolePermissionsMap[currentRoleId].forEach(permId => {
                    const cb = document.getElementById('perm_' + permId);
                    if (cb) cb.checked = true;
                });
            }

            // 3. Apply FORBIDDEN overrides
            if (forbiddenPermissionIds) {
                forbiddenPermissionIds.forEach(permId => {
                    const cb = document.getElementById('perm_' + permId);
                    if (cb) cb.checked = false;
                });
            }

            // 4. Apply GRANTED overrides
            if (grantedPermissionIds) {
                grantedPermissionIds.forEach(permId => {
                     const cb = document.getElementById('perm_' + permId);
                     if (cb) cb.checked = true;
                });
            }

            // MODE HANDLING
            const roleCol = document.getElementById('roleColumnContent');
            const permCol = document.getElementById('permissionColumnContent');
            const title = document.getElementById('roleModalTitle');
            
            // Reset visibility
            roleCol.style.display = 'block';
            permCol.style.display = 'block';
            document.querySelector('.grid-2-responsive').style.gridTemplateColumns = 'repeat(auto-fit, minmax(300px, 1fr))';

            if (mode === 'permissions_only') {
                // Permissions Only
                roleCol.style.display = 'none';
                title.innerText = 'Modifier les Exceptions (Permissions) : ' + userName;
                document.querySelector('.grid-2-responsive').style.gridTemplateColumns = '1fr';
            } else if (mode === 'role_only') {
                // Role Only
                permCol.style.display = 'none';
                title.innerText = 'Changer le Rôle : ' + userName;
                document.querySelector('.grid-2-responsive').style.gridTemplateColumns = '1fr';
            } else {
                // Full Mode
                title.innerText = 'Gérer Rôle & Permissions : ' + userName;
            }
        }


        function closeRoleModal() {
            document.getElementById('roleModal').style.display = 'none';
        }

        // When a role is selected, update checkboxes to match the role defaults
        function updatePermissionsFromRole(roleId) {
            // Uncheck all first
            document.querySelectorAll('input[name="permissions[]"]').forEach(cb => cb.checked = false);

            if (rolePermissionsMap[roleId]) {
                rolePermissionsMap[roleId].forEach(permId => {
                    const cb = document.getElementById('perm_' + permId);
                    if (cb) cb.checked = true;
                });
            }
        }
    </script>
@endsection
