@extends('layouts.admin')

@section('content')
    <h1 style="font-size: 1.8rem; font-weight: 700; margin-bottom: 2rem;">Statistiques Globales</h1>

    <!-- Key Metrics Grid -->
    <div class="grid-4" style="margin-bottom: 2rem;">
        <!-- Global Occupation Rate (Highlight) -->
        <div class="card stat-card" style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(59, 130, 246, 0.05)); border-color: rgba(59, 130, 246, 0.3);">
            <h3>Taux d'Occupation</h3>
            <div class="value" style="color: #60a5fa;">{{ $occupationRate }}%</div>
            <div style="margin-top: 10px; height: 8px; background: rgba(255,255,255,0.1); border-radius: 4px; overflow: hidden;">
                <div style="height: 100%; width: {{ $occupationRate }}%; background: #3b82f6; transition: width 1s;"></div>
            </div>
        </div>

        <div class="card stat-card">
            <h3>Total Ressources</h3>
            <div class="value">{{ $totalResources }}</div>
        </div>

        <div class="card stat-card">
            <h3>Total Utilisateurs</h3>
            <div class="value">{{ $totalUsers }}</div>
        </div>

        <div class="card stat-card">
            <h3>En Maintenance</h3>
            <div class="value" style="color: #fbbf24;">{{ $totalMaintenance }}</div>
        </div>
    </div>

    <!-- Charts Section -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem; margin-top: 2rem;">
        
        <!-- Chart 1: Resource Types -->
        <div class="card" style="display: flex; flex-direction: column; align-items: center; padding: 2.5rem;">
            <h2 style="margin-bottom: 2rem; width: 100%; text-align: center; border-bottom: 1px solid var(--border); padding-bottom: 1rem;">
                <i class="fas fa-server" style="color: var(--accent); margin-right: 10px;"></i>Répartition par Type
            </h2>
            
            @if($totalResources > 0)
                @php
                    // Muted/Professional Palette
                    $typeColors = [
                        'serveur' => '#0ea5e9',         // Sky Blue (Calm)
                        'machine_virtuelle' => '#6366f1', // Indigo (Deep)
                        'equipement_reseau' => '#14b8a6', // Teal (Professional)
                        'baie_stockage' => '#ec4899'      // Pink/Rose (Distinct but not neon orange)
                    ];
                    $typeLabels = [
                        'serveur' => 'Serveurs', 
                        'machine_virtuelle' => 'Machines Virtuelles', 
                        'equipement_reseau' => 'Équipements Réseau', 
                        'baie_stockage' => 'Baies de Stockage'
                    ];
                    $cumulative = 0;
                    $gradients = [];
                    foreach(['serveur', 'machine_virtuelle', 'equipement_reseau', 'baie_stockage'] as $type) {
                        $count = $resourcesByType[$type] ?? 0;
                        if($count > 0) {
                            $percent = ($count / $totalResources) * 100;
                            $end = $cumulative + $percent;
                            $gradients[] = "{$typeColors[$type]} {$cumulative}% {$end}%";
                            $cumulative = $end;
                        }
                    }
                    $conicType = !empty($gradients) ? implode(', ', $gradients) : '#334155 0% 100%'; 
                @endphp

                <!-- RESIZED CHART: 180px -->
                <div style="position: relative; width: 180px; height: 180px; margin-bottom: 2.5rem;">
                    <div style="width: 100%; height: 100%; border-radius: 50%; background: conic-gradient({{ $conicType }}); box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);"></div>
                    <div style="position: absolute; inset: 25px; background: var(--bg-surface); border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center; box-shadow: inset 0 0 15px rgba(0,0,0,0.5);">
                        <span style="font-size: 2rem; font-weight: 800; color: var(--text-primary);">{{ $totalResources }}</span>
                        <span style="font-size: 0.8rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">Total</span>
                    </div>
                </div>

                <div style="width: 100%;">
                    @foreach(['serveur', 'machine_virtuelle', 'equipement_reseau', 'baie_stockage'] as $type)
                        @php 
                            $count = $resourcesByType[$type] ?? 0;
                            $percent = $totalResources > 0 ? round(($count / $totalResources) * 100, 1) : 0;
                        @endphp
                        @if($count > 0)
                        <div class="flex justify-between items-center" style="padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.05);">
                            <div class="flex items-center gap-3">
                                <div style="width: 12px; height: 12px; border-radius: 50%; background: {{ $typeColors[$type] }};"></div>
                                <span style="color: var(--text-secondary);">{{ $typeLabels[$type] }}</span>
                                <!-- PERCENTAGE MOVED HERE -->
                                <span style="background: rgba(255,255,255,0.05); padding: 2px 6px; border-radius: 4px; font-size: 0.8rem; font-weight: 600; color: {{ $typeColors[$type] }};">{{ $percent }}%</span>
                            </div>
                            <div class="text-right">
                                <span style="font-weight: 700; color: var(--text-primary); font-size: 1.1rem;">{{ $count }}</span>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="incident-empty" style="width: 100%;">
                    <i class="fas fa-cubes" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                    <p>Aucune donnée disponible</p>
                </div>
            @endif
        </div>

        <!-- Chart 2: Resource Status -->
        <div class="card" style="display: flex; flex-direction: column; align-items: center; padding: 2.5rem;">
            <h2 style="margin-bottom: 2rem; width: 100%; text-align: center; border-bottom: 1px solid var(--border); padding-bottom: 1rem;">
                <i class="fas fa-chart-pie" style="color: #f59e0b; margin-right: 10px;"></i>Répartition par Statut
            </h2>

            @if($totalResources > 0)
                @php
                    // Muted/Standard Palette for Status
                    $statusColors = [
                        'disponible' => '#22c55e',  // Green (Standard Success)
                        'reserve' => '#3b82f6',     // Blue (Standard Info)
                        'maintenance' => '#f59e0b'  // Orange/Amber (Standard Warning)
                    ];
                    $statusLabels = [
                        'disponible' => 'Disponible', 
                        'reserve' => 'Réservé', 
                        'maintenance' => 'Maintenance'
                    ];
                    $cumulative = 0;
                    $gradients = [];
                    foreach(['disponible', 'reserve', 'maintenance'] as $status) {
                        $count = $resourcesByStatus[$status] ?? 0;
                        if($count > 0) {
                            $percent = ($count / $totalResources) * 100;
                            $end = $cumulative + $percent;
                            $gradients[] = "{$statusColors[$status]} {$cumulative}% {$end}%";
                            $cumulative = $end;
                        }
                    }
                    $conicStatus = !empty($gradients) ? implode(', ', $gradients) : '#334155 0% 100%';
                @endphp

                <!-- RESIZED CHART: 180px -->
                <div style="position: relative; width: 180px; height: 180px; margin-bottom: 2.5rem;">
                    <div style="width: 100%; height: 100%; border-radius: 50%; background: conic-gradient({{ $conicStatus }}); box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);"></div>
                    <div style="position: absolute; inset: 25px; background: var(--bg-surface); border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center; box-shadow: inset 0 0 15px rgba(0,0,0,0.5);">
                        <span style="font-size: 2rem; font-weight: 800; color: var(--text-primary);">{{ $totalResources }}</span>
                        <span style="font-size: 0.8rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 1px;">Total</span>
                    </div>
                </div>

                <div style="width: 100%;">
                    @foreach(['disponible', 'reserve', 'maintenance'] as $status)
                        @php 
                            $count = $resourcesByStatus[$status] ?? 0;
                            $percent = $totalResources > 0 ? round(($count / $totalResources) * 100, 1) : 0;
                        @endphp
                        @if($count > 0)
                        <div class="flex justify-between items-center" style="padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.05);">
                            <div class="flex items-center gap-3">
                                <div style="width: 12px; height: 12px; border-radius: 50%; background: {{ $statusColors[$status] }};"></div>
                                <span style="color: var(--text-secondary);">{{ $statusLabels[$status] }}</span>
                                <!-- PERCENTAGE MOVED HERE -->
                                <span style="background: rgba(255,255,255,0.05); padding: 2px 6px; border-radius: 4px; font-size: 0.8rem; font-weight: 600; color: {{ $statusColors[$status] }};">{{ $percent }}%</span>
                            </div>
                            <div class="text-right">
                                <span style="font-weight: 700; color: var(--text-primary); font-size: 1.1rem;">{{ $count }}</span>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="incident-empty" style="width: 100%;">
                    <i class="fas fa-chart-area" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                    <p>Aucune donnée disponible</p>
                </div>
            @endif
        </div>
    </div>
@endsection
