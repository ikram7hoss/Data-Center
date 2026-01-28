@extends('layouts.responsable')

@section('content')

<div style="padding: 30px; background: #f8fafc; min-height: 100vh; font-family: sans-serif;">
    <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 30px;">

        <div style="background: #1e3a8a; padding: 15px; border-radius: 12px;">

            <svg style="width: 30px; height: 30px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
             </svg>
        </div>

        <div>
            <h1 style="margin: 0; font-size: 24px; color: #1e293b;">Demandes de réservation</h1>
            <p style="margin: 0; color: #64748b;">Gérez les demandes de réservation des utilisateurs</p>
        </div>
    </div>

    {{-- Notification Flash --}}

    @if(session('success'))

        <div id="flash-message" style="background: #dcfce7; color: #166534; padding: 15px; border-radius: 12px; margin-bottom: 20px; border: 1px solid #bbf7d0; display: flex; align-items: center; gap: 10px;">

            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>

            </svg>

            {{ session('success') }}

        </div>

        <script>

            setTimeout(() => {

                const msg = document.getElementById('flash-message');

                if(msg) msg.style.display = 'none';

            }, 3000);

        </script>

    @endif

    {{-- Navigation par Onglets --}}

    <div style="display: flex; gap: 10px; margin-bottom: 25px;">

        @php $currentTab = request('tab', 'en_attente'); @endphp

        <a href="?tab=en_attente" style="text-decoration:none; padding: 10px 20px; border-radius: 20px; border: none; background: {{ $currentTab == 'en_attente' ? '#1e3a8a' : 'white' }}; color: {{ $currentTab == 'en_attente' ? 'white' : '#64748b' }}; font-weight: bold; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
            En attente
        </a>

        <a href="?tab=approuvee" style="text-decoration:none; padding: 10px 20px; border-radius: 20px; border: none; background: {{ $currentTab == 'approuvee' ? '#1e3a8a' : 'white' }}; color: {{ $currentTab == 'approuvee' ? 'white' : '#64748b' }}; font-weight: bold; cursor: pointer;">
            Approuvées
        </a>

        <a href="?tab=refusee" style="text-decoration:none; padding: 10px 20px; border-radius: 20px; border: none; background: {{ $currentTab == 'refusee' ? '#1e3a8a' : 'white' }}; color: {{ $currentTab == 'refusee' ? 'white' : '#64748b' }}; font-weight: bold; cursor: pointer;">
              Refusées
        </a>

    </div>

    <div style="background: white; border-radius: 15px; border: 1px solid #e2e8f0; overflow: hidden;">

        @if($demandes->isEmpty())

            <div style="padding: 50px; text-align: center; color: #94a3b8;">
                 <p>Aucune réservation "{{ str_replace('_', ' ', $currentTab) }}" trouvée</p>
            </div>

        @else
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">

                        <th style="padding: 15px; color: #64748b; font-size: 13px;">UTILISATEUR</th>

                        <th style="padding: 15px; color: #64748b; font-size: 13px;">RESSOURCE</th>

                        <th style="padding: 15px; color: #64748b; font-size: 13px;">PÉRIODE</th>

                        <th style="padding: 15px; color: #64748b; font-size: 13px;">{{ $currentTab == 'refusee' ? 'MOTIF' : 'STATUT' }}</th>

                        <th style="padding: 15px; color: #64748b; font-size: 13px; text-align: right;">ACTIONS</th>
                    </tr>
                </thead>

                <tbody>
                     @foreach($demandes as $demande)
                    <tr style="border-bottom: 1px solid #f1f5f9;">

                        <td style="padding: 15px;">
    <div style="display: flex; align-items: center; gap: 10px;">
        {{-- Petit avatar par défaut pour faire pro --}}
        <div style="width: 32px; height: 32px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #64748b;">
            <i class="fas fa-user" style="font-size: 14px;"></i>
        </div>
        <div>
            <span style="display: block; font-weight: 600; color: #1e293b;">
                {{ $demande->user->name ?? 'Utilisateur inconnu' }}
            </span>
        </div>
    </div>
</td>

                        <td style="padding: 15px;">{{ $demande->ressource->name ?? 'Machine #'.$demande->ressource_id }}</td>

                        <td style="padding: 15px; font-size: 13px; color: #64748b;">

                            Du {{ $demande->periode_start }}<br>Au {{ $demande->periode_end }}

                        </td>

                        <td style="padding: 15px;">

                            @if($currentTab == 'refusee')

                                <span style="font-size: 12px; color: #ef4444;">{{ $demande->raison_refus }}</span>

                            @else

                                <span style="padding: 4px 10px; border-radius: 20px; font-size: 12px;
                                   background: {{ $demande->status == 'approuvee' ? '#dcfce7' : '#fef3c7' }};
                                   color: {{ $demande->status == 'approuvee' ? '#166534' : '#92400e' }};">
                                   {{ $demande->status }}
                                </span>
                            @endif

                        </td>
                        <td style="padding: 15px; text-align: right;">

                            @if($demande->status == 'en_attente')

                            <div style="display: flex; justify-content: flex-end; gap: 8px;">

                                <form action="{{ route('demandes.approuver', $demande->id) }}" method="POST">

                                    @csrf

                                    <button type="submit" style="background: #10b981; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer;">Approuver</button>

                                </form>

                                <button onclick="openRefusModal({{ $demande->id }})" style="background: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer;">Refuser</button>

                            </div>

                            @else

                                <span style="color: #94a3b8; font-size: 12px;">Traité le {{ optional($demande->updated_at)->format('d/m/Y') }}
</span>

                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

{{-- Modale inchangée --}}
<div id="refusModal" style="display:none; position:fixed; z-index:9999; top:0; left:0; width:100%; height:100%; background:rgba(15, 23, 42, 0.5); backdrop-filter: blur(4px);">
    <div style="background:white; width:450px; margin:10% auto; padding:0; border-radius:20px; overflow:hidden; box-shadow: 0 20px 25px rgba(0,0,0,0.1);">
        <div style="padding: 20px; border-bottom: 1px solid #f1f5f9;">
             <h3 style="margin:0; color:#1e293b;">Justification du refus</h3>
        </div>

        <form id="refusForm" method="POST">

            @csrf

            <div style="padding: 20px;">

                <label style="display:block; font-size:13px; color:#64748b; margin-bottom:8px;">Veuillez indiquer la raison du refus :</label>

                <textarea name="raison_refus" rows="4" style="width:100%; border:1px solid #e2e8f0; border-radius:10px; padding:12px; box-sizing:border-box;" placeholder="Ex: Ressource déjà réservée..." required></textarea>

            </div>

            <div style="padding: 20px; background: #f8fafc; display: flex; justify-content: flex-end; gap: 10px;">

                <button type="button" onclick="document.getElementById('refusModal').style.display='none'" style="padding: 8px 15px; background:white; border:1px solid #e2e8f0; border-radius:8px; cursor:pointer;">Annuler</button>

                <button type="submit" style="padding: 8px 15px; background:#ef4444; color:white; border:none; border-radius:8px; cursor:pointer;">Confirmer le refus</button>

            </div>

        </form>

    </div>

</div>
<script>

function openRefusModal(id) {

    const modal = document.getElementById('refusModal');

    const form = document.getElementById('refusForm');

    form.action = "/responsable/demandes/" + id + "/refuser";

    modal.style.display = 'block';

}
</script>

@endsection