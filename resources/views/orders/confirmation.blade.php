@extends('layouts.app')
@section('title', 'Confirmation de commande — e-car')
@section('content')
<div class="section">
<div class="container" style="max-width:700px;text-align:center;">

    <div style="font-size:5rem;margin-bottom:1rem;">🎉</div>
    <h1 style="font-size:2rem;font-weight:900;margin-bottom:0.75rem;">Commande <span class="heading-accent">confirmée !</span></h1>
    <p style="color:var(--text-muted);font-size:1rem;margin-bottom:2.5rem;">
        Merci <strong style="color:var(--text-white)">{{ $order->nom_client }}</strong> ! Votre commande a bien été enregistrée. Un conseiller vous contactera au <strong style="color:var(--accent)">{{ $order->telephone }}</strong> pour finaliser.
    </p>

    <div class="card" style="text-align:left;margin-bottom:2rem;">
        <div style="display:flex;justify-content:space-between;margin-bottom:1rem;padding-bottom:1rem;border-bottom:1px solid var(--bg-border);">
            <div>
                <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:0.2rem;">Référence</div>
                <div style="font-weight:800;font-family:monospace;color:var(--accent);">{{ $order->reference }}</div>
            </div>
            <div style="text-align:right">
                <div style="font-size:0.78rem;color:var(--text-muted);margin-bottom:0.2rem;">Statut</div>
                <span class="badge badge-warning">⏳ En attente</span>
            </div>
        </div>

        <div style="font-weight:700;margin-bottom:0.75rem;font-size:0.88rem;text-transform:uppercase;letter-spacing:0.3px;color:var(--text-muted);">Articles commandés</div>
        @foreach($order->items as $item)
        <div style="display:flex;justify-content:space-between;font-size:0.88rem;padding:0.5rem 0;border-bottom:1px solid var(--bg-border);">
            <span>{{ $item->titre_voiture }} <span style="color:var(--text-muted)">× {{ $item->quantite }}</span></span>
            <span style="font-weight:700;color:var(--accent);">{{ $item->prix_formatte }}</span>
        </div>
        @endforeach

        <div style="display:flex;justify-content:space-between;margin-top:1rem;font-size:1.1rem;font-weight:900;">
            <span>Total</span>
            <span style="color:var(--accent);">{{ $order->total_formatte }}</span>
        </div>
    </div>

    <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
        <a href="{{ route('home') }}" class="btn-primary">Retour à l'accueil</a>
        <a href="{{ route('voitures.index') }}" class="btn-outline">Voir d'autres voitures</a>
    </div>
</div>
</div>
@endsection
