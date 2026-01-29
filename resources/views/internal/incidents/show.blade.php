@extends('layouts.internal')

@section('content')
<p><a href="{{ route('internal.incidents.index') }}">← Retour</a></p>

<h1>Incident #{{ $incident->id }}</h1>

<p><strong>Ressource:</strong> {{ $incident->ressource->name ?? '—' }}</p>
<p><strong>Titre:</strong> {{ $incident->title }}</p>
<p><strong>Description:</strong> {{ $incident->description }}</p>
<p><strong>Sévérité:</strong> {{ $incident->severity }}</p>
<p><strong>Status:</strong> {{ $incident->status }}</p>
<p><strong>Créé le:</strong> {{ $incident->created_at }}</p>
@endsection
