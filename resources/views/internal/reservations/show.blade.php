@extends('layouts.internal')

@section('content')
<div style="margin-bottom: 20px;">
    <a href="{{ route('internal.reservations.index') }}">← Retour à mes demandes</a>
</div>

<h1>Détail de la demande #{{ $demande->id }}</h1>

<div style="background: #f8f9fa; padding: 20px; border-radius: 8px; border: 1px solid #ddd;">
    <h3>Informations de Réservation</h3>
    <p><strong>Statut de la demande :</strong> 
        <span class="status-{{ $demande->status }}" style="font-weight: bold; text-transform: uppercase;">
            {{ $demande->status }}
        </span>
    </p>
    <p><strong>Période :</strong> Du {{ $demande->periode_start }} au {{ $demande->periode_end }}</p>
    <p><strong>Justification :</strong> {{ $demande->justification ?? 'Aucune justification fournie' }}</p>

    <hr>

    <h3>Détails de la Ressource</h3>
    <p><strong>Nom :</strong> {{ $demande->ressource->name ?? '—' }}</p>
    <p><strong>Type :</strong> {{ $demande->ressource->type ?? '—' }}</p>
    <p><strong>État actuel de la ressource :</strong> {{ $demande->ressource->status ?? '—' }}</p>
</div>

@if($demande->status == 'active')
    <div style="margin-top: 20px; padding: 15px; background: #fff3cd; border: 1px solid #ffeeba; border-radius: 5px;">
        <strong>Action :</strong> 
        <a href="{{ route('internal.incidents.create', ['reservation_id' => $demande->id]) }}">
            ⚠️ Signaler un incident technique sur cette ressource
        </a>
    </div>
@endif

@endsection


