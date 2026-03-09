@extends('layouts.app')
@section('title', 'Votre Panier — e-car')
@section('content')
<div class="section">
<div class="container">
    <h1 class="section-title" style="margin-bottom:2rem;">Mon <span class="heading-accent">Panier</span></h1>

    @if($cart->items->isEmpty())
    <div style="text-align:center;padding:5rem 0;">
        <div style="font-size:5rem;margin-bottom:1rem;"></div>
        <div style="font-size:1.2rem;font-weight:700;margin-bottom:0.5rem;">Votre panier est vide</div>
        <p style="color:var(--text-muted);margin-bottom:2rem;">Ajoutez des voitures depuis le catalogue.</p>
        <a href="{{ route('voitures.index') }}" class="btn-primary" style="font-size:1rem;padding:0.75rem 2rem;">
            Voir le catalogue
        </a>
    </div>
    @else
    <div style="display:grid;grid-template-columns:1fr 350px;gap:2rem;align-items:start;">

    {{-- Items --}}
    <div>
        @foreach($cart->items as $item)
        <div class="card" style="display:flex;gap:1.25rem;align-items:center;margin-bottom:1rem;">
            {{-- Image --}}
            <div style="flex-shrink:0;">
                @if($item->voiture->images && count($item->voiture->images) > 0)
                    <img src="{{ asset('storage/'.$item->voiture->images[0]) }}" alt="{{ $item->voiture->titre }}"
                         style="width:110px;height:80px;object-fit:cover;border-radius:8px;border:1px solid var(--bg-border)">
                @else
                    <div style="width:110px;height:80px;background:var(--bg-border);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:2.5rem;">
                        {{ $item->voiture->category->icone ?? '🚗' }}
                    </div>
                @endif
            </div>
            {{-- Infos --}}
            <div style="flex:1;min-width:0;">
                <div style="font-weight:700;font-size:0.95rem;margin-bottom:0.25rem;">{{ $item->voiture->titre }}</div>
                <div style="font-size:0.78rem;color:var(--text-muted);">
                    {{ $item->voiture->annee }} • {{ ucfirst($item->voiture->carburant) }} • {{ ucfirst($item->voiture->etat) }}
                </div>
            </div>
            {{-- Prix --}}
            <div style="text-align:right;flex-shrink:0;">
                <div style="font-weight:900;color:var(--accent);font-size:1rem;">{{ $item->voiture->prix_formatte }}</div>
                <div style="font-size:0.78rem;color:var(--text-muted);margin-top:0.2rem;">× {{ $item->quantite }}</div>
            </div>
            {{-- Retirer --}}
            <form method="POST" action="{{ route('cart.retirer') }}">
                @csrf
                <input type="hidden" name="item_id" value="{{ $item->id }}">
                <button type="submit" class="btn-danger btn-sm">🗑️</button>
            </form>
        </div>
        @endforeach

        <form method="POST" action="{{ route('cart.vider') }}" onsubmit="return confirm('Vider le panier ?')">
            @csrf
            <button type="submit" class="btn-danger" style="margin-top:0.5rem;">Vider le panier</button>
        </form>
    </div>

    {{-- Résumé --}}
    <div class="card" style="position:sticky;top:80px;">
        <div style="font-weight:800;font-size:1rem;margin-bottom:1.25rem;">Résumé de la commande</div>

        @foreach($cart->items as $item)
        <div style="display:flex;justify-content:space-between;font-size:0.85rem;color:var(--text-muted);margin-bottom:0.5rem;">
            <span>{{ Str::limit($item->voiture->titre, 28) }}</span>
            <span>{{ $item->voiture->prix_formatte }}</span>
        </div>
        @endforeach

        <div style="border-top:1px solid var(--bg-border);margin:1rem 0;padding-top:1rem;display:flex;justify-content:space-between;align-items:center;">
            <span style="font-weight:700;">Total</span>
            <span style="font-size:1.4rem;font-weight:900;color:var(--accent);">{{ $cart->total_formatte }}</span>
        </div>

        <a href="{{ route('orders.create') }}" class="btn-primary" style="width:100%;justify-content:center;padding:0.9rem;font-size:1rem;display:flex;margin-bottom:0.75rem;">
            ✅ Passer la commande
        </a>
        <a href="{{ route('voitures.index') }}" class="btn-outline" style="width:100%;justify-content:center;display:flex;padding:0.75rem;">
            ← Continuer les achats
        </a>

        <div style="margin-top:1rem;font-size:0.78rem;color:var(--text-muted);text-align:center;">
            Prix en Ariary Malgache (Ar) · TVA incluse
        </div>
    </div>

    </div>
    @endif
</div>
</div>
@endsection
