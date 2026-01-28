@extends('layouts.internal')

@section('content')
<h1>Créer une demande</h1>
@if ($errors->any())
  <div>
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif


<form method="POST" action="{{ route('reservations.store') }}">
  @csrf

  <label>Ressource</label>
  <select name="ressource_id">
    @foreach($ressources as $r)
      <option value="{{ $r->id }}">{{ $r->name }} ({{ $r->type }})</option>
    @endforeach
  </select>
  <label>Date début</label>
<input type="date" name="periode_start" value="{{ old('periode_start') }}"required>

<label>Date fin</label>
<input type="date" name="periode_end" value="{{ old('periode_end') }}" required>

<label>Justification</label>
<textarea name="justification">{{ old('justification') }}</textarea>

  <button type="submit">Envoyer</button>
</form>
