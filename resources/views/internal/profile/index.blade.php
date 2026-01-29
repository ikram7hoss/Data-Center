@extends('layouts.internal')

@section('content')
<h1>Mon Profil</h1>

<div style="background: #f9f9f9; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
    <h3>Informations personnelles</h3>
    <p><strong>Nom :</strong> {{ $user->name }}</p>
    <p><strong>Email :</strong> {{ $user->email }}</p>
</div>

<div style="background: #fff; padding: 20px; border-radius: 8px; border: 1px solid #ddd;">
    <h3>Modifier le mot de passe</h3>
    
    <form method="POST" action="{{ route('internal.profile.password') }}">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 10px;">
            <label>Mot de passe actuel :</label><br>
            <input type="password" name="current_password" required>
        </div>

        <div style="margin-bottom: 10px;">
            <label>Nouveau mot de passe :</label><br>
            <input type="password" name="password" required>
        </div>

        <div style="margin-bottom: 10px;">
            <label>Confirmer le nouveau mot de passe :</label><br>
            <input type="password" name="password_confirmation" required>
        </div>

        <button type="submit" style="background: #2196f3; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer;">
            Mettre à jour
        </button>
    </form>
</div>
@endsection