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

    <div class="grid-2-responsive" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 2rem;">
        
        <!-- Resources by Type -->
        <div class="card">
            <h2 class="mb-3">Répartition par Type</h2>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @foreach(['serveur' => 'Serveurs', 'machine_virtuelle' => 'Machines Virtuelles', 'equipement_reseau' => 'Équipements Réseau', 'baie_stockage' => 'Stockage'] as $key => $label)
                    @php 
                        $count = $resourcesByType[$key] ?? 0;
                        $percentage = $totalResources > 0 ? ($count / $totalResources) * 100 : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between mb-1">
                            <span style="font-weight: 500; color: var(--text-secondary);">{{ $label }}</span>
                            <span style="font-weight: 700;">{{ $count }}</span>
                        </div>
                        <div style="height: 6px; background: rgba(255,255,255,0.05); border-radius: 3px; overflow: hidden;">
                            <div style="height: 100%; width: {{ $percentage }}%; background: var(--text-secondary); opacity: 0.7;"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Resources by Status -->
        <div class="card">
            <h2 class="mb-3">État des Ressources</h2>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @php
                    $statuses = [
                        'disponible' => ['label' => 'Disponible', 'color' => '#34d399'],
                        'reserve' => ['label' => 'Réservé', 'color' => '#60a5fa'],
                        'maintenance' => ['label' => 'Maintenance', 'color' => '#fbbf24'],
                    ];
                @endphp

                @foreach($statuses as $key => $config)
                    @php 
                        $count = $resourcesByStatus[$key] ?? 0;
                        $percentage = $totalResources > 0 ? ($count / $totalResources) * 100 : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between mb-1">
                            <span style="font-weight: 500; color: var(--text-secondary);">{{ $config['label'] }}</span>
                            <span style="font-weight: 700; color: {{ $config['color'] }};">{{ $count }}</span>
                        </div>
                        <div style="height: 6px; background: rgba(255,255,255,0.05); border-radius: 3px; overflow: hidden;">
                            <div style="height: 100%; width: {{ $percentage }}%; background: {{ $config['color'] }}; box-shadow: 0 0 10px {{ $config['color'] }};"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Pie Charts Row -->
        <div class="card" style="grid-column: 1 / -1;">
            <div style="display: flex; flex-wrap: wrap; gap: 2rem; justify-content: center;">
                
                <!-- Chart 1: Global Status -->
                <div style="flex: 1; min-width: 300px; padding: 1rem;">
                    <h2 class="mb-3" style="text-align: center;">État Global</h2>
                    
                    @if($totalResources > 0)
                        @php
                            $statusColors = ['disponible' => '#34d399', 'reserve' => '#60a5fa', 'maintenance' => '#fbbf24'];
                            $statusLabels = ['disponible' => 'Disponible', 'reserve' => 'Réservé', 'maintenance' => 'Maintenance'];
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
                            $conicStatus = implode(', ', $gradients);
                        @endphp
                        <div style="display: flex; flex-direction: column; align-items: center; gap: 1.5rem;">
                            <div style="width: 160px; height: 160px; border-radius: 50%; background: conic-gradient({{ $conicStatus }}); position: relative; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
                                <div style="position: absolute; inset: 20px; background: var(--bg-surface); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                                    <span style="font-size: 1.5rem; font-weight: 700;">{{ $totalResources }}</span>
                                    <span style="font-size: 0.7rem; color: var(--text-secondary);">Total</span>
                                </div>
                            </div>
                            <!-- Legend (Mini) -->
                            <div style="width: 100%;">
                                @foreach(['disponible', 'reserve', 'maintenance'] as $status)
                                    @php $count = $resourcesByStatus[$status] ?? 0; @endphp
                                    @if($count > 0)
                                    <div class="flex justify-between items-center mb-1" style="font-size: 0.85rem;">
                                        <div class="flex items-center gap-2"><span style="width: 8px; height: 8px; background: {{ $statusColors[$status] }}; border-radius: 2px;"></span> {{ $statusLabels[$status] }}</div>
                                        <div>{{ $count }}</div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Chart 2: Global Type Distribution -->
                <div style="flex: 1; min-width: 300px; border-left: 1px solid var(--border); padding: 1rem;">
                    <h2 class="mb-3" style="text-align: center;">Répartition par Type</h2>
                    
                    @if($totalResources > 0)
                        @php
                            $typeColors = ['serveur' => '#3b82f6', 'machine_virtuelle' => '#8b5cf6', 'equipement_reseau' => '#10b981', 'baie_stockage' => '#f59e0b'];
                            $typeLabels = ['serveur' => 'Serveurs', 'machine_virtuelle' => 'Vrtuelles', 'equipement_reseau' => 'Réseau', 'baie_stockage' => 'Stockage'];
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
                            $conicType = implode(', ', $gradients);
                        @endphp
                        <div style="display: flex; flex-direction: column; align-items: center; gap: 1.5rem;">
                            <div style="width: 160px; height: 160px; border-radius: 50%; background: conic-gradient({{ $conicType }}); position: relative; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
                                <div style="position: absolute; inset: 20px; background: var(--bg-surface); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                                    <span style="font-size: 1.5rem; font-weight: 700;">{{ $totalResources }}</span>
                                    <span style="font-size: 0.7rem; color: var(--text-secondary);">Total</span>
                                </div>
                            </div>
                            <!-- Legend -->
                            <div style="width: 100%;">
                                @foreach(['serveur', 'machine_virtuelle', 'equipement_reseau', 'baie_stockage'] as $type)
                                    @php $count = $resourcesByType[$type] ?? 0; @endphp
                                    @if($count > 0)
                                    <div class="flex justify-between items-center mb-1" style="font-size: 0.85rem;">
                                        <div class="flex items-center gap-2"><span style="width: 8px; height: 8px; background: {{ $typeColors[$type] }}; border-radius: 2px;"></span> {{ $typeLabels[$type] }}</div>
                                        <div>{{ $count }}</div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Chart 3: Reserved Breakdown -->
                <div style="flex: 1; min-width: 300px; border-left: 1px solid var(--border); padding: 1rem;">
                    <h2 class="mb-3" style="text-align: center;">Détail Réservations</h2>
                    
                    @if($totalReserved > 0)
                        @php
                            $cumulative = 0;
                            $gradients = [];
                            foreach(['serveur', 'machine_virtuelle', 'equipement_reseau', 'baie_stockage'] as $type) {
                                $count = $reservedByType[$type] ?? 0;
                                if($count > 0) {
                                    $percent = ($count / $totalReserved) * 100;
                                    $end = $cumulative + $percent;
                                    $gradients[] = "{$typeColors[$type]} {$cumulative}% {$end}%";
                                    $cumulative = $end;
                                }
                            }
                            $conicReserved = implode(', ', $gradients);
                        @endphp
                        <div style="display: flex; flex-direction: column; align-items: center; gap: 1.5rem;">
                            <div style="width: 160px; height: 160px; border-radius: 50%; background: conic-gradient({{ $conicReserved }}); position: relative; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
                                <div style="position: absolute; inset: 20px; background: var(--bg-surface); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                                    <span style="font-size: 1.5rem; font-weight: 700;">{{ $totalReserved }}</span>
                                    <span style="font-size: 0.7rem; color: var(--text-secondary);">Réservé(s)</span>
                                </div>
                            </div>
                            <!-- Legend -->
                            <div style="width: 100%;">
                                @foreach(['serveur', 'machine_virtuelle', 'equipement_reseau', 'baie_stockage'] as $type)
                                    @php $count = $reservedByType[$type] ?? 0; @endphp
                                    @if($count > 0)
                                    <div class="flex justify-between items-center mb-1" style="font-size: 0.85rem;">
                                        <div class="flex items-center gap-2"><span style="width: 8px; height: 8px; background: {{ $typeColors[$type] }}; border-radius: 2px;"></span> {{ $typeLabels[$type] }}</div>
                                        <div>{{ $count }}</div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div style="text-align: center; color: var(--text-secondary); margin-top: 3rem;">Aucune réservation.</div>
                    @endif
                </div>
            </div>
        </div>
@endsection
