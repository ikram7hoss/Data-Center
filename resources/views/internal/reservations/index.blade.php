@extends('layouts.internal')

@section('content')
<h1>Mes demandes</h1>
<form method="GET" style="margin:12px 0; display:flex; gap:10px; flex-wrap:wrap;">
  <label>
    Statut:
    <select name="status">
      <option value="">-- tous --</option>
      @foreach(['en_attente','approuvee','refusee','active','terminee','conflit'] as $s)
        <option value="{{ $s }}" @selected(request('status') === $s)>{{ $s }}</option>
      @endforeach
    </select>
  </label>

  <label>
    Ressource:
    <select name="ressource_id">
      <option value="">-- toutes --</option>
      @foreach($ressources as $r)
        <option value="{{ $r->id }}" @selected(request('ressource_id') == $r->id)>{{ $r->name }}</option>
      @endforeach
    </select>
  </label>

  <label>
    Du:
    <input type="date" name="from" value="{{ request('from') }}">
  </label>

  <label>
    Au:
    <input type="date" name="to" value="{{ request('to') }}">
  </label>

  <button type="submit">Filtrer</button>
  <a href="{{ route('internal.reservations.index') }}">Reset</a>
</form>


<ul>
  @foreach($demandes as $d)
    <li>
      <a href="{{ route('internal.reservations.show', $d->id)}}">#{{ $d->id }}</a>
      | Ressource: {{ $d->ressource->name ?? '—' }}
      | {{ $d->periode_start }} → {{ $d->periode_end }}
      | Statut: <span class="status status-{{ $d->status }}">{{ $d->status }}</span>
      
      @if($d->status == 'active')
        | <a href="{{ route('internal.incidents.create', ['reservation_id' => $d->id]) }}" class="incident-action">⚠️ Signaler un incident</a>
      @else
        | <span class="incident-disabled">⚠️ Incident (disponible quand actif)</span>
      @endif

      @if(in_array($d->status, ['en_attente', 'refusee']))
        | <form action="{{ route('internal.reservations.destroy', $d->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Annuler cette demande ?');">
            @csrf
            @method('DELETE')
            <button type="submit" style="color: red; background: none; border: none; padding: 0; cursor: pointer; text-decoration: underline;">Annuler</button>
          </form>
      @endif
    </li>
  @endforeach
</ul>

@if($demandes->where('status', 'active')->isEmpty())
  <div class="incident-hint">Les incidents sont disponibles uniquement pour les demandes actives.</div>
@endif
@endsection
