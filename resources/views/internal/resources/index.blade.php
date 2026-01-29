@extends('layouts.internal')

@section('content')
<style>
    /* High Contrast Styles for Readability */
    .page-title {
        color: #000000;
        margin-bottom: 25px;
        font-weight: 800;
        font-size: 2rem;
    }
    
    .filter-panel {
        background: #ffffff;
        padding: 25px;
        border-radius: 12px;
        margin-bottom: 35px;
        border: 2px solid #e2e8f0;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }

    .filter-label {
        font-weight: 700;
        font-size: 1rem;
        color: #1a202c; /* Almost black */
        margin-bottom: 8px;
        display: block;
    }

    .filter-select {
        padding: 12px;
        border-radius: 8px;
        border: 2px solid #cbd5e0;
        background: #fff;
        color: #000;
        font-size: 1rem;
        font-weight: 500;
        width: 100%;
        min-width: 200px;
    }
    .filter-select:focus {
        border-color: #3182ce;
        outline: none;
    }

    .btn-filter {
        background: #2b6cb0; /* Strong Blue */
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-filter:hover {
        background: #2c5282;
    }

    .btn-reset {
        color: #4a5568;
        font-weight: 600;
        text-decoration: underline;
        padding: 12px;
    }

    /* Resource Cards */
    .resource-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
    }

    .resource-card {
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        padding: 25px;
        background: white;
        position: relative;
        transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
    }
    .resource-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px rgba(0,0,0,0.1);
        border-color: #bee3f8;
    }

    .status-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 0.85rem;
        text-transform: uppercase;
        font-weight: 800;
        padding: 6px 14px;
        border-radius: 50px;
        border: 1px solid transparent;
    }
    .status-available {
        background: #c6f6d5;
        color: #22543d;
        border-color: #9ae6b4;
    }
    .status-unavailable {
        background: #fed7d7;
        color: #822727;
        border-color: #feb2b2;
    }

    .resource-icon {
        font-size: 3rem;
        margin-bottom: 20px;
    }

    .resource-name {
        margin: 0 0 15px 0;
        color: #000;
        font-size: 1.4rem;
        font-weight: 700;
    }

    .resource-type {
        color: #2d3748;
        font-size: 0.95rem;
        font-weight: 600;
        margin-bottom: 25px;
        background: #edf2f7;
        padding: 8px 12px;
        border-radius: 6px;
        display: inline-block;
        border: 1px solid #e2e8f0;
    }

    .btn-reserve {
        display: block;
        width: 100%;
        text-align: center;
        background: #3182ce;
        color: white;
        text-decoration: none;
        padding: 14px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 1.1rem;
        transition: background 0.2s;
    }
    .btn-reserve:hover {
        background: #2b6cb0;
        text-decoration: none;
    }

    .btn-disabled {
        width: 100%;
        background: #edf2f7;
        color: #a0aec0;
        border: 2px dashed #cbd5e0;
        padding: 14px;
        border-radius: 10px;
        font-weight: 600;
        cursor: not-allowed;
    }
</style>

<h1 class="page-title">📦 Ressources disponibles</h1>

<div class="filter-panel">
    <form action="{{ route('internal.resources.index') }}" method="GET" style="display: flex; gap: 20px; flex-wrap: wrap; align-items: flex-end;">
        
        <div style="flex: 1; min-width: 200px;">
            <label class="filter-label">Filtrer par type :</label>
            <select name="type" class="filter-select">
                <option value="">Tous les types</option>
                <option value="machines_virtuelles" {{ request('type') == 'machines_virtuelles' ? 'selected' : '' }}>🖥️ Machines virtuelles</option>
                <option value="baies_stockage" {{ request('type') == 'baies_stockage' ? 'selected' : '' }}>🗄️ Baies de stockage</option>
                <option value="equipements_reseau" {{ request('type') == 'equipements_reseau' ? 'selected' : '' }}>🌐 Équipements réseau</option>
            </select>
        </div>

        <div style="flex: 1; min-width: 200px;">
            <label class="filter-label">Disponibilité :</label>
            <select name="status" class="filter-select">
                <option value="">Tous les états</option>
                <option value="disponible" {{ request('status') == 'disponible' ? 'selected' : '' }}>✅ Disponible</option>
                <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>🛠️ En maintenance</option>
            </select>
        </div>

        <div style="display: flex; gap: 15px; align-items: center;">
            <button type="submit" class="btn-filter">
                Filtrer
            </button>
            <a href="{{ route('internal.resources.index') }}" class="btn-reset">Réinitialiser</a>
        </div>
    </form>
</div>

<div class="resource-grid">
    @forelse($ressources as $res)
        <div class="resource-card">
            
            <span class="status-badge {{ $res->status == 'disponible' ? 'status-available' : 'status-unavailable' }}">
                {{ $res->status }}
            </span>
            
            <div class="resource-icon">
                @if($res->type == 'machines_virtuelles') 🖥️ 
                @elseif($res->type == 'baies_stockage') 🗄️ 
                @elseif($res->type == 'equipements_reseau') 🌐 
                @else 📦 @endif
            </div>

            <h3 class="resource-name">{{ $res->name }}</h3>
            
            <div class="resource-type">
                Type: {{ str_replace('_', ' ', ucfirst($res->type)) }}
            </div>
            
            @if($res->status == 'disponible')
                <a href="{{ route('internal.reservations.create', ['resource_id' => $res->id]) }}" class="btn-reserve">
                   Réserver maintenant
                </a>
            @else
                <button disabled class="btn-disabled">
                   Non disponible
                </button>
            @endif
        </div>
    @empty
        <div style="grid-column: 1 / -1; text-align: center; color: #4a5568; padding: 60px; background: #fff; border-radius: 12px; border: 2px dashed #cbd5e0;">
            <p style="font-size: 1.2rem; font-weight: 500;">🔍 Aucune ressource trouvée avec ces filtres.</p>
        </div>
    @endforelse
</div>
@endsection