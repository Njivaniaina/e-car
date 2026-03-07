@extends('layouts.app')
@section('title', 'Mon Historique — E-Mobile')
@section('content')
<div class="section">
<div class="container" style="max-width:980px;">
    <h1 class="section-title">📋 Mon <span class="heading-accent">Historique</span></h1>
    <p class="section-subtitle">Retrouvez toutes vos commandes passées sur E-Mobile.</p>

    @if($orders->isEmpty())
    <div class="card" style="text-align:center; padding:4rem 0;">
        <div style="font-size:4rem; margin-bottom:1rem;">📋</div>
        <div style="font-size:1.1rem; font-weight:700; margin-bottom:0.5rem;">Aucune commande trouvée</div>
        <p style="color:var(--text-muted); margin-bottom:2rem;">Vous n'avez pas encore passé de commande.</p>
        <a href="{{ route('voitures.index') }}" class="btn-primary">🔍 Voir le catalogue</a>
    </div>
    @else
    @foreach($orders as $order)
    <div class="card" style="margin-bottom:1.5rem; border-left:4px solid var(--accent);">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem;">
            <div>
                <div style="font-size:0.72rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px;">Référence</div>
                <div style="font-weight:800; font-family:monospace; color:var(--accent); font-size:1.15rem;">{{ $order->reference }}</div>
            </div>
            <div style="text-align:right;">
                <div style="font-size:0.72rem; color:var(--text-muted); text-transform:uppercase; margin-bottom:0.4rem;">Statut</div>
                <span class="badge badge-{{ $order->statut_color }}" style="font-size:0.85rem; padding:0.4rem 0.8rem;">{{ $order->statut_label }}</span>
            </div>
        </div>

        <div style="display:grid; grid-template-columns:2fr 1fr; gap:2rem; padding:1.25rem; background:rgba(255,255,255,0.02); border-radius:10px;">
            <div>
                <div style="margin-bottom:0.75rem; font-weight:700; font-size:0.85rem; color:var(--text-muted);">Articles :</div>
                @foreach($order->items as $item)
                <div style="display:flex; justify-content:space-between; font-size:0.92rem; margin-bottom:0.35rem;">
                    <span>{{ $item->titre_voiture }} <span style="color:var(--text-muted);">× {{ $item->quantite }}</span></span>
                    <span style="font-weight:600;">{{ $item->prix_formatte }}</span>
                </div>
                @endforeach
            </div>
            <div style="text-align:right; border-left:1px solid var(--bg-border); padding-left:1.5rem;">
                <div style="color:var(--text-muted); font-size:0.75rem; margin-bottom:0.2rem;">TOTAL RÉGLÉ</div>
                <div style="font-size:1.5rem; font-weight:900; color:var(--accent);">{{ $order->total_formatte }}</div>
                <div style="color:var(--text-muted); font-size:0.82rem; margin-top:0.5rem;">Le {{ $order->created_at->format('d/m/Y') }}</div>
            </div>
        </div>

        <div style="margin-top:1.25rem; display:flex; justify-content:space-between; align-items:center;">
            <div style="font-size:0.82rem; color:var(--text-muted);">
                📞 Téléphone de contact : <span style="color:var(--text-white); font-weight:600;">{{ $order->telephone }}</span>
            </div>
            <a href="{{ route('orders.confirmation', $order->reference) }}" class="btn-outline btn-sm">Version imprimable →</a>
        </div>
    </div>
    @endforeach

    <div style="margin-top:2rem;">
        {{ $orders->links() }}
    </div>
    @endif
</div>
</div>
@endsection
