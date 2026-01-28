@extends('layouts.internal')

@section('content')
<div style="color: #1a202c;">
    <h1 style="margin-bottom: 20px;">Tableau de bord</h1>

    @php
        $roleColors = [
            'ingénieur' => ['bg' => '#e8f5e9', 'text' => '#2e7d32', 'label' => '🛠️ Ingénieur'],
            'enseignant' => ['bg' => '#fff3e0', 'text' => '#ef6c00', 'label' => '👨‍🏫 Enseignant'],
            'doctorant' => ['bg' => '#f3e5f5', 'text' => '#7b1fa2', 'label' => '🎓 Doctorant'],
        ];
        $currentRole = strtolower(auth()->user()->role ?? 'utilisateur');
        $style = $roleColors[$currentRole] ?? ['bg' => '#f4f7f6', 'text' => '#4a5568', 'label' => $currentRole];
    @endphp

    <p style="font-size: 1.1em; margin-bottom: 30px;">
        Bienvenue, <strong>{{ auth()->user()->name }}</strong> 
        <span style="background: {{ $style['bg'] }}; color: {{ $style['text'] }}; padding: 4px 12px; border-radius: 15px; font-size: 0.8em; font-weight: bold; margin-left: 10px; border: 1px solid {{ $style['text'] }};">
            {{ $style['label'] }}
        </span>
    </p>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px;">
        <div style="padding: 20px; background: #ebf8ff; border-left: 5px solid #3182ce; border-radius: 8px;">
            <div style="font-size: 0.9em; color: #2b6cb0; font-weight: bold;">Réservations actives</div>
            <div style="font-size: 2em; font-weight: bold; color: #2c5282;">{{ $activeReservationsCount ?? 0 }}</div>
        </div>
        
        <div style="padding: 20px; background: #fffaf0; border-left: 5px solid #dd6b20; border-radius: 8px;">
            <div style="font-size: 0.9em; color: #9c4221; font-weight: bold;">Demandes en attente</div>
            <div style="font-size: 2em; font-weight: bold; color: #7b341e;">{{ $pendingDemandsCount ?? 0 }}</div>
        </div>

        <div style="padding: 20px; background: #fff5f5; border-left: 5px solid #e53e3e; border-radius: 8px;">
            <div style="font-size: 0.9em; color: #9b2c2c; font-weight: bold;">Incidents ouverts</div>
            <div style="font-size: 2em; font-weight: bold; color: #742a2a;">{{ $openIncidentsCount ?? 3 }}</div>
        </div>
    </div>

    <h2 style="font-size: 1.3em; margin-bottom: 15px;">Activités récentes</h2>
    <div style="border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; background: white;">
            <thead style="background: #f8f9fa;">
                <tr>
                    <th style="text-align: left; padding: 12px; border-bottom: 1px solid #e2e8f0; color: #4a5568;">Ressource</th>
                    <th style="text-align: left; padding: 12px; border-bottom: 1px solid #e2e8f0; color: #4a5568;">Date</th>
                    <th style="text-align: left; padding: 12px; border-bottom: 1px solid #e2e8f0; color: #4a5568;">Statut</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="3" style="padding: 30px; text-align: center; color: #a0aec0;">Aucune activité récente.</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection