@extends('layouts.internal')

@section('content')
<h1>Mes incidents</h1>

<ul>
  @foreach($incidents as $i)
    <li>
      <a href="{{ route('internal.incidents.show', $i->id) }}">#{{ $i->id }}</a>

      | Ressource: {{ $i->ressource->name ?? '—' }}
      | {{ $i->title }}
      | Severity: {{ $i->severity }}
      | Status: {{ $i->status }}
      | {{ $i->created_at }}
    </li>
  @endforeach
</ul>
@endsection
