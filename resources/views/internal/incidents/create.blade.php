@extends('layouts.internal')

@section('content')
<h1>Signaler un incident technique</h1>

@if ($errors->any())

  <div>

    <ul>

      @foreach ($errors->all() as $error)

        <li>{{ $error }}</li>

      @endforeach

    </ul>

  </div>

@endif

<form action="{{ route('internal.incidents.store') }}" method="POST">
    @csrf

    <div style="margin-bottom: 15px;">
        <label>Ressource concernée :</label><br>
        <select name="ressource_id" required>
            <option value="">-- Choisir une ressource --</option>
            @foreach($ressources as $r)
                <option value="{{ $r->id }}" {{ $selected_resource_id == $r->id ? 'selected' : '' }}>
                    {{ $r->name }} ({{ $r->type }})
                </option>
            @endforeach
        </select>
    </div>

    @if($selected_reservation_id)
        <input type="hidden" name="reservation_id" value="{{ $selected_reservation_id }}">
        <p><small>Lié à la réservation #{{ $selected_reservation_id }}</small></p>
    @endif

    <div style="margin-bottom: 15px;">
        <label>Description du problème :</label><br>
        <textarea name="description" rows="5" style="width: 100%;" placeholder="Décrivez précisément le souci rencontré..." required></textarea>
    </div>

    <div style="margin-bottom: 15px;">
        <label>Urgence :</label><br>
        <select name="priority">
            <option value="low">Faible</option>
            <option value="medium" selected>Moyenne</option>
            <option value="high">Haute / Bloquant</option>
        </select>
    </div>

    <button type="submit" style="background: #e3342f; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
        Envoyer le signalement
    </button>
</form>
@endsection

