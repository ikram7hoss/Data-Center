@extends('layouts.internal')

@section('content')
<h1>Mes demandes</h1>

<ul>
  @foreach($demandes as $d)
    <li>
      <a href="{{ route('reservations.show', $d->id) }}">#{{ $d->id }}</a>
      | Ressource: {{ $d->ressource->name ?? '—' }}
      | {{ $d->periode_start }} → {{ $d->periode_end }}
      | Statut: <span class="status status-{{ $d->status }}">{{ $d->status }}</span>
    </li>
  @endforeach
</ul>
@endsection

