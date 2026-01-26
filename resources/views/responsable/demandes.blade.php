@extends('layouts.responsable')

@section('content')
<div style="padding: 30px; background: #f8fafc; min-height: 100vh;">
    
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

    <div style="display: flex; gap: 10px; margin-bottom: 25px;">
        <button style="padding: 10px 20px; border-radius: 20px; border: none; background: white; color: #1e293b; font-weight: bold; box-shadow: 0 2px 4px rgba(0,0,0,0.05); cursor: pointer;">En attente</button>
        <button style="padding: 10px 20px; border-radius: 20px; border: none; background: transparent; color: #64748b; cursor: pointer;">Approuvées ({{ $demandes->where('status', 'Approuvée')->count() }})</button>
        <button style="padding: 10px 20px; border-radius: 20px; border: none; background: transparent; color: #64748b; cursor: pointer;">Actives ()</button>
        <button style="padding: 10px 20px; border-radius: 20px; border: none; background: transparent; color: #64748b; cursor: pointer;">Toutes ({{ $demandes->count() }})</button>
    </div>

    <div style="background: white; padding: 15px; border-radius: 12px; margin-bottom: 20px; display: flex; align-items: center; border: 1px solid #e2e8f0;">
        <svg style="width: 20px; height: 20px; color: #94a3b8; margin-right: 10px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
        <input type="text" placeholder="Rechercher par ressource ou utilisateur..." style="border: none; outline: none; width: 100%; font-size: 15px;">
    </div>

    <div style="background: white; border-radius: 15px; min-height: 300px; display: flex; align-items: center; justify-content: center; border: 1px dashed #cbd5e1;">
        @if($demandes->isEmpty())
            <p style="color: #94a3b8; font-size: 16px;">Aucune réservation trouvée</p>
        @else
            <table style="width: 100%; border-collapse: collapse; margin: 20px;">
                </table>
        @endif
    </div>
</div>
@endsection