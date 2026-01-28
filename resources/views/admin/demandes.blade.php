@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 style="font-size: 1.8rem; font-weight: 700;">Gestion des Demandes</h1>
    </div>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>Ressource</th>
                    <th>Période</th>
                    <th>Justification</th>
                    <th>Date Demande</th>
                    <th>Statut</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($demandes as $demande)
                <tr>
                    <td>
                        <div class="font-bold">{{ $demande->user->name }}</div>
                        <div class="text-sm opacity-50">{{ $demande->user->email }}</div>
                    </td>
                    <td>
                        <div class="font-bold">{{ $demande->ressource->name }}</div>
                        <div class="text-sm opacity-50">{{ $demande->ressource->type }}</div>
                    </td>
                    <td>
                        <span style="font-size: 0.85rem;">
                            {{ $demande->periode_start ? $demande->periode_start->format('d/m/Y') : 'N/A' }} 
                            <i class="fas fa-arrow-right mx-1" style="font-size: 0.7rem;"></i> 
                            {{ $demande->periode_end ? $demande->periode_end->format('d/m/Y') : 'N/A' }}
                        </span>
                    </td>
                    <td style="max-width: 200px; white-space: normal;">
                        {{ $demande->justification ?? 'Aucune' }}
                    </td>
                    <td>
                        <span style="font-size: 0.85rem; color: var(--text-secondary);">
                            {{ $demande->created_at->format('d/m/Y H:i') }}
                        </span>
                    </td>
                    <td>
                        @if($demande->status === 'en_attente')
                            <span class="badge bg-warning">En Attente</span>
                        @elseif($demande->status === 'approuvee')
                            <span class="badge bg-success">Approuvée</span>
                        @elseif($demande->status === 'refusee')
                            <span class="badge bg-danger">Refusée</span>
                        @else
                            <span class="badge bg-secondary">{{ ucfirst($demande->status) }}</span>
                        @endif
                    </td>
                    <td class="flex items-center gap-2" style="justify-content: flex-end;">
                        @if($demande->status === 'en_attente')
                            <!-- Approve -->
                            <form action="{{ route('admin.demandes.approve', $demande->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline" title="Approuver" style="color: #34d399; border-color: rgba(52, 211, 153, 0.3);">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>

                            <!-- Refuse -->
                            <form action="{{ route('admin.demandes.refuse', $demande->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline" title="Refuser" style="color: #f87171; border-color: rgba(248, 113, 113, 0.3);">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        @else
                            @if($demande->status === 'approuvee')
                                <span style="color: #34d399; font-size: 0.9rem;"><i class="fas fa-check-circle"></i> Validé</span>
                            @elseif($demande->status === 'refusee')
                                <span style="color: #f87171; font-size: 0.9rem;"><i class="fas fa-times-circle"></i> Refusé</span>
                            @endif
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 2rem; color: var(--text-muted);">Aucune demande trouvée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
