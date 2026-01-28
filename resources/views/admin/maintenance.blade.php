@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 style="font-size: 1.8rem; font-weight: 700;">Gestion de la Maintenance</h1>
        
        <div class="flex items-center gap-3" style="gap: 1rem;">
            <!-- Type Filter -->
            <form action="{{ route('admin.maintenance') }}" method="GET">
                <select name="type" onchange="this.form.submit()" style="padding: 0.6rem 1rem; border-radius: 12px; border: 1px solid var(--border); background: var(--bg-surface); color: var(--text-secondary); cursor: pointer; font-size: 0.9rem;">
                    <option value="">Tous les types</option>
                    @foreach(['serveur', 'machine_virtuelle', 'equipement_reseau', 'baie_stockage'] as $type)
                        <option value="{{ $type }}" {{ (isset($queryType) && $queryType == $type) ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $type)) }}
                        </option>
                    @endforeach
                </select>
            </form>

            <button class="btn btn-primary" onclick="openModal()">
                <i class="fas fa-calendar-plus" style="margin-right: 8px;"></i> Planifier Maintenance
            </button>
        </div>
    </div>

    <!-- Section 1: Resources Currently in Maintenance -->
    <div class="card mb-3 border-top-warning">
        <h2 style="font-size: 1.2rem; display: flex; align-items: center; gap: 10px; margin-bottom: 1.5rem;">
            <i class="fas fa-exclamation-triangle" style="color: var(--warning);"></i> 
            Ressources en Maintenance Actuelle
        </h2>

        @if($resourcesUnderMaintenance->count() > 0)
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Ressource</th>
                            <th>Type</th>
                            <th>État</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($resourcesUnderMaintenance as $res)
                        <tr>
                            <td><strong>{{ $res->name }}</strong></td>
                            <td>{{ $res->type }}</td>
                            <td><span class="badge bg-warning">En Maintenance</span></td>
                            <td class="text-right">
                                <form action="{{ route('admin.resources.maintenance', $res->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline" title="Terminer Maintenance" style="color: #34d399; border-color: rgba(52, 211, 153, 0.3);">
                                        <i class="fas fa-check"></i> Rétablir
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="padding: 2rem; text-align: center; color: var(--text-muted); background: rgba(255,255,255,0.02); border-radius: var(--radius-sm);">
                <i class="fas fa-check-circle" style="font-size: 2rem; color: var(--success); margin-bottom: 1rem; display: block;"></i>
                Aucune ressource n'est actuellement en maintenance. Tout est opérationnel.
            </div>
        @endif
    </div>

    <!-- Section 2: Maintenance Periods History -->
    <div class="card">
        <h2 style="font-size: 1.2rem; margin-bottom: 1.5rem;">Historique et Planification</h2>
        
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Ressource</th>
                        <th>Début</th>
                        <th>Fin (Prévue)</th>
                        <th>Raison</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($maintenancePeriods as $period)
                    <tr>
                        <td>{{ $period->ressource->name }}</td>
                        <td>{{ $period->start_date->format('d/m/Y H:i') }}</td>
                        <td>{{ $period->end_date ? $period->end_date->format('d/m/Y H:i') : '-' }}</td>
                        <td>{{ $period->reason }}</td>
                        <td>
                            @if($period->status === 'ongoing')
                                <span class="badge bg-warning">En cours</span>
                            @elseif($period->status === 'completed')
                                <span class="badge bg-success">Terminé</span>
                            @elseif($period->status === 'scheduled')
                                <span class="badge bg-primary">Planifié</span>
                            @else
                                <span class="badge bg-danger">{{ $period->status }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 2rem; color: var(--text-muted);">
                            Aucune période de maintenance enregistrée.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </div>

    <!-- Modal Planifier Maintenance -->
    <div id="maintenanceModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.8); z-index: 1000; align-items: center; justify-content: center; animation: fadeIn 0.2s;">
        <div class="card" style="width: 100%; max-width: 500px; margin: 2rem;">
            <div class="flex justify-between items-center mb-3">
                <h2>Planifier une Maintenance</h2>
                <button type="button" onclick="closeModal()" style="background:none; border:none; color:var(--text-secondary); font-size:1.5rem; cursor:pointer;">&times;</button>
            </div>

            <form action="{{ route('admin.maintenance.store') }}" method="POST">
                @csrf
                <div class="mb-3" style="margin-bottom: 1rem;">
                    <label style="display:block; margin-bottom: 0.5rem; color: var(--text-secondary);">Ressource</label>
                    <select name="ressource_id" style="width: 100%; padding: 0.75rem; border-radius: var(--radius-sm); background: var(--bg-app); border: 1px solid var(--border); color: var(--text-primary);">
                        @foreach(\App\Models\Ressource::all() as $r)
                            <option value="{{ $r->id }}">{{ $r->name }} ({{ $r->status }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid-4" style="grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display:block; margin-bottom: 0.5rem; color: var(--text-secondary);">Début</label>
                        <input type="datetime-local" name="start_date" required style="width: 100%; padding: 0.75rem; border-radius: var(--radius-sm); background: var(--bg-app); border: 1px solid var(--border); color: var(--text-primary);">
                    </div>
                    <div>
                        <label style="display:block; margin-bottom: 0.5rem; color: var(--text-secondary);">Fin (Optionnel)</label>
                        <input type="datetime-local" name="end_date" style="width: 100%; padding: 0.75rem; border-radius: var(--radius-sm); background: var(--bg-app); border: 1px solid var(--border); color: var(--text-primary);">
                        <small style="color: var(--text-secondary); font-size: 0.8rem;">Par défaut: +5 jours</small>
                    </div>
                </div>

                <div class="mb-3" style="margin-bottom: 2rem;">
                    <label style="display:block; margin-bottom: 0.5rem; color: var(--text-secondary);">Raison</label>
                    <input type="text" name="reason" placeholder="Ex: Mise à jour sécurité..." required style="width: 100%; padding: 0.75rem; border-radius: var(--radius-sm); background: var(--bg-app); border: 1px solid var(--border); color: var(--text-primary);">
                </div>

                <div class="flex justify-between">
                    <button type="button" onclick="closeModal()" class="btn btn-outline" style="color: #94a3b8; border-color: #475569;">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('maintenanceModal').style.display = 'flex';
        }
        function closeModal() {
            document.getElementById('maintenanceModal').style.display = 'none';
        }
    </script>
@endsection
