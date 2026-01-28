@extends('layouts.internal')

@section('content')
<h1>Mes incidents</h1>

<div class="incident-list">
    @forelse($incidents as $i)
        <a class="incident-card" href="{{ route('internal.incidents.show', $i->id) }}">
            <div class="incident-header">
                <div class="incident-title">
                    <span class="incident-id">#{{ $i->id }}</span>
                    <span class="incident-name">{{ $i->title }}</span>
                </div>
                <span class="incident-date">{{ $i->created_at }}</span>
            </div>

            <div class="incident-meta">
                <span class="incident-pill">Ressource: {{ $i->ressource->name ?? '—' }}</span>
                <span class="incident-pill">Severity: {{ $i->severity }}</span>
                <span class="incident-pill">Status: {{ $i->status }}</span>
            </div>
        </a>
    @empty
        <div class="incident-empty">Aucun incident trouvé.</div>
    @endforelse
</div>
@endsection
