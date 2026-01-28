@extends('layouts.internal')

@section('content')
<h1>Internal - Resources</h1>

<form method="GET">
  <label>Type:</label>
  <input name="type" value="{{ request('type') }}">

  <label>Status:</label>
  <input name="status" value="{{ request('status') }}">

  <button type="submit">Filtrer</button>
</form>
<ul>
  @foreach($ressources as $r)
    <li>{{ $r->id }} - {{ $r->name }} ({{ $r->type }}) - {{ $r->status }}</li>
  @endforeach
</ul>
@endsection