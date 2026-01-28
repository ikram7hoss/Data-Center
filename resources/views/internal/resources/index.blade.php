@extends('layouts.internal')

@section('content')
<h1 style="margin-bottom: 20px; color: #1a202c;">📦 Ressources disponibles</h1>

<div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 30px; border: 1px solid #e2e8f0;">
    <form action="{{ route('internal.resources.index') }}" method="GET" style="display: flex; gap: 20px; flex-wrap: wrap; align-items: flex-end;">
        
        <div style="display: flex; flex-direction: column; gap: 8px;">
            <label style="font-weight: bold; font-size: 0.9em; color: #2d3748;">Filtrer par type :</label>
            <select name="type" style="padding: 10px; border-radius: 6px; border: 1px solid #cbd5e0; background: white; color: #1a202c; min-width: 200px;">
                <option value="">Tous les types</option>
                <option value="machines_virtuelles" {{ request('type') == 'machines_virtuelles' ? 'selected' : '' }}>🖥️ Machines virtuelles</option>
                <option value="baies_stockage" {{ request('type') == 'baies_stockage' ? 'selected' : '' }}>🗄️ Baies de stockage</option>
                <option value="equipements_reseau" {{ request('type') == 'equipements_reseau' ? 'selected' : '' }}>🌐 Équipements réseau</option>
            </select>
        </div>

        <div style="display: flex; flex-direction: column; gap: 8px;">
            <label style="font-weight: bold; font-size: 0.9em; color: #2d3748;">Disponibilité :</label>
            <select name="status" style="padding: 10px; border-radius: 6px; border: 1px solid #cbd5e0; background: white; color: #1a202c; min-width: 150px;">
                <option value="">Tous les états</option>
                <option value="disponible" {{ request('status') == 'disponible' ? 'selected' : '' }}>✅ Disponible</option>
                <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>🛠️ En maintenance</option>
            </select>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" style="background: #3182ce; color: white; border: none; padding: 11px 25px; border-radius: 6px; cursor: pointer; font-weight: bold;">
                Filtrer
            </button>
            <a href="{{ route('internal.resources.index') }}" style="text-decoration: none; color: #718096; padding: 10px; font-size: 0.9em;">Réinitialiser</a>
        </div>
    </form>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 25px;">
    @forelse($ressources as $res)
        <div style="border: 1px solid #e2e8f0; border-radius: 12px; padding: 25px; background: white; position: relative; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
            
            <span style="position: absolute; top: 15px; right: 15px; font-size: 0.7em; text-transform: uppercase; font-weight: 800; padding: 5px 10px; border-radius: 20px; 
                background: {{ $res->status == 'disponible' ? '#c6f6d5' : '#fed7d7' }}; 
                color: {{ $res->status == 'disponible' ? '#22543d' : '#822727' }}; border: 1px solid currentColor;">
                {{ $res->status }}
            </span>
            
            <div style="font-size: 2.5em; margin-bottom: 15px;">
                @if($res->type == 'machines_virtuelles') 🖥️ 
                @elseif($res->type == 'baies_stockage') 🗄️ 
                @elseif($res->type == 'equipements_reseau') 🌐 
                @else 📦 @endif
            </div>

            <h3 style="margin: 0 0 10px 0; color: #1a202c;">{{ $res->name }}</h3>
            
            <p style="color: #4a5568; font-size: 0.9em; margin-bottom: 20px; background: #edf2f7; padding: 5px 10px; border-radius: 5px; display: inline-block;">
                Type: <strong>{{ str_replace('_', ' ', ucfirst($res->type)) }}</strong>
            </p>
            
            @if($res->status == 'disponible')
                <a href="{{ route('internal.reservations.create', ['resource_id' => $res->id]) }}" 
                   style="display: block; text-align: center; background: #3182ce; color: white; text-decoration: none; padding: 12px; border-radius: 8px; font-weight: bold;">
                   Réserver
                </a>
            @else
                <button disabled style="width: 100%; background: #f7fafc; color: #a0aec0; border: 1px dashed #cbd5e0; padding: 12px; border-radius: 8px; cursor: not-allowed;">
                   Indisponible
                </button>
            @endif
        </div>
    @empty
        <div style="grid-column: 1 / -1; text-align: center; color: #718096; padding: 60px; background: #f8f9fa; border-radius: 12px; border: 2px dashed #e2e8f0;">
            <p>🔍 Aucune ressource trouvée.</p>
        </div>
    @endforelse
</div>
@endsection