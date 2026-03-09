@extends('layouts.app')
@section('title', 'Admin — Dashboard')
@section('content')
<div class="section">
<div class="container">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;">
        <h1 class="section-title">Dashboard <span class="heading-accent">Admin</span></h1>
        <a href="{{ route('admin.voitures.create') }}" class="btn-primary">+ Ajouter une voiture</a>
    </div>

    {{-- Stats --}}
    <div class="grid-4" style="margin-bottom:2.5rem;">
        <div class="stat-card" style="border-color:rgba(232,160,0,0.2);">
            <div class="stat-card-value" style="color:var(--accent)">{{ $stats['voitures'] }}</div>
            <div class="stat-card-label">Voitures (total)</div>
        </div>
        <div class="stat-card" style="border-color:rgba(34,197,94,0.2);">
            <div class="stat-card-value" style="color:var(--success)">{{ $stats['voitures_active'] }}</div>
            <div class="stat-card-label">Voitures actives</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-value">{{ $stats['commandes'] }}</div>
            <div class="stat-card-label">Commandes (total)</div>
        </div>
        <div class="stat-card" style="border-color:rgba(234,179,8,0.2);">
            <div class="stat-card-value" style="color:#eab308">{{ $stats['en_attente'] }}</div>
            <div class="stat-card-label">En attente de confirmation</div>
        </div>
    </div>

    {{-- Revenu --}}
    <div class="card" style="margin-bottom:2rem;border-color:rgba(232,160,0,0.15);background:linear-gradient(135deg,rgba(232,160,0,0.04),transparent);">
        <div style="font-size:0.82rem;text-transform:uppercase;letter-spacing:0.4px;color:var(--text-muted);margin-bottom:0.4rem;">Revenus confirmés</div>
        <div style="font-size:2.5rem;font-weight:900;color:var(--accent);">{{ number_format($stats['revenu'], 0, ',', ' ') }} Ar</div>
        <div style="font-size:0.8rem;color:var(--text-muted);margin-top:0.3rem;">Commandes confirmées et livrées</div>
    </div>

    {{-- Nav rapide --}}
    <div class="grid-4" style="margin-bottom:2.5rem;">
        @foreach([
            ['url' => route('admin.voitures'), 'icon' => '', 'label' => 'Gérer les voitures'],
            ['url' => route('admin.commandes'), 'icon' => '', 'label' => 'Gérer les commandes'],
            ['url' => route('admin.categories'), 'icon' => '', 'label' => 'Catégories'],
            ['url' => route('admin.marques'), 'icon' => '', 'label' => 'Marques'],
        ] as $nav)
        <a href="{{ $nav['url'] }}" class="card" style="text-align:center;transition:all 0.2s;display:block;"
           onmouseover="this.style.borderColor='rgba(232,160,0,0.3)';this.style.transform='translateY(-2px)'"
           onmouseout="this.style.borderColor='var(--bg-border)';this.style.transform=''">
            <div style="font-size:2rem;margin-bottom:0.5rem;">{{ $nav['icon'] }}</div>
            <div style="font-weight:700;font-size:0.9rem;">{{ $nav['label'] }}</div>
        </a>
        @endforeach
    </div>

    {{-- Dernières commandes --}}
    <div class="card">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;">
            <div style="font-weight:800;">Dernières commandes</div>
            <a href="{{ route('admin.commandes') }}" class="btn-outline btn-sm">Voir tout →</a>
        </div>
        @if($dernieres_commandes->isEmpty())
        <p style="color:var(--text-muted);text-align:center;padding:1.5rem 0;">Aucune commande pour l'instant.</p>
        @else
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Client</th>
                        <th>Total</th>
                        <th>Statut</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dernieres_commandes as $cmd)
                    <tr>
                        <td><a href="{{ route('admin.commandes.show', $cmd) }}" style="color:var(--accent);font-family:monospace;font-size:0.82rem;">{{ $cmd->reference }}</a></td>
                        <td>{{ $cmd->nom_client }}</td>
                        <td style="font-weight:700;color:var(--accent)">{{ $cmd->total_formatte }}</td>
                        <td><span class="badge badge-{{ $cmd->statut_color }}">{{ $cmd->statut_label }}</span></td>
                        <td style="color:var(--text-muted);font-size:0.8rem;">{{ $cmd->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
</div>
@endsection
