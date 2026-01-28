@extends('layouts.internal')

@section('content')
<h1>Mon Profil</h1>
<ul>
    <li><strong>Nom :</strong> {{ $user->name }}</li>
    <li><strong>Email :</strong> {{ $user->email }}</li>
    <li><strong>Type :</strong> {{ $user->type }}</li>
</ul>

<a href="{{ route('internal.reservations.index') }}">Voir mon historique de réservations</a>
@endsection