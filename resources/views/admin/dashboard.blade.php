@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 style="font-size: 1.8rem; font-weight: 700;">Tableau de bord</h1>
        <div>
            <span style="color: var(--text-muted);">{{ now()->format('d M Y') }}</span>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid-4 mb-3">
        <div class="card stat-card border-top-primary">
            <h3>Utilisateurs Total</h3>
            <div class="value">{{ $totalUsers }}</div>
            <div class="desc text-muted">Inscrits sur la plateforme</div>
        </div>
        <div class="card stat-card border-top-success">
            <h3>Ressources</h3>
            <div class="value">{{ $totalResources }}</div>
            <div class="desc text-muted">{{ $usagePercentage }}% Allouées</div>
        </div>
        <div class="card stat-card border-top-warning">
            <h3>Réservations Actives</h3>
            <div class="value">{{ $activeReservations }}</div>
            <div class="desc text-muted">En cours d'utilisation</div>
        </div>
        <div class="card stat-card border-top-danger">
            <h3>Demandes en Attente</h3>
            <div class="value">{{ $pendingDemandes }}</div>
            <div class="desc text-muted">Nécessitent une action</div>
        </div>
    </div>

    <!-- Quick Sections -->

@endsection
