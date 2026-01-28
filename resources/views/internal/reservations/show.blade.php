@extends('layouts.internal')

@section('content')
<p><a href="{{ route('reservations.index') }}">← Retour à mes demandes</a></p>
<h1>Détail demande #{{ $demande->id }}</h1>

<p><strong>Ressource:</strong> {{ $demande->ressource->name ?? '—' }}</p>
<p><strong>Période:</strong> {{ $demande->periode_start }} → {{ $demande->periode_end }}</p>
<p><strong>Justification:</strong> {{ $demande->justification ?? '—' }}</p>
<p><strong>Type:</strong> {{ $demande->ressource->type ?? '—' }}</p>
<p><strong>Status ressource:</strong> {{ $demande->ressource->status ?? '—' }}</p>


<p><a href="{{ route('reservations.index') }}">← Retour à mes demandes</a></p>
<p><strong>Statut demande:</strong> {{ $demande->status }}</p>
@endsection


