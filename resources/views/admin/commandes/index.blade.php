@extends('layouts.app')
@section('title', 'Admin — Commandes')
@section('content')
<div class="section">
<div class="container">
    <h1 class="section-title">Gestion des <span class="heading-accent">Commandes</span></h1>
    <p class="section-subtitle">{{ $commandes->total() }} commande(s) au total</p>

    <div class="card">
        @if($commandes->isEmpty())
        <p style="text-align:center; padding:2rem; color:var(--text-muted);">Aucune commande enregistrée.</p>
        @else
        <table class="data-table">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Client</th>
                    <th>Téléphone</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($commandes as $cmd)
                <tr>
                    <td><span style="font-family:monospace; color:var(--accent); font-weight:700;">{{ $cmd->reference }}</span></td>
                    <td>{{ $cmd->nom_client }}</td>
                    <td>{{ $cmd->telephone }}</td>
                    <td style="font-weight:700; color:var(--accent);">{{ $cmd->total_formatte }}</td>
                    <td>
                        <span class="badge badge-{{ $cmd->statut_color }}">{{ $cmd->statut_label }}</span>
                    </td>
                    <td style="font-size:0.82rem; color:var(--text-muted);">{{ $cmd->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.commandes.show', $cmd) }}" class="btn-outline btn-sm">Détails</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top:2rem;">
            {{ $commandes->links() }}
        </div>
        @endif
    </div>
</div>
</div>
@endsection
