@extends('layouts.app')
@section('title', 'Passer une commande — E-Mobile')
@section('content')
<div class="section">
<div class="container" style="max-width:900px;">
    <h1 class="section-title" style="margin-bottom:2rem;">Finaliser la <span class="heading-accent">commande</span></h1>

    <div style="display:grid;grid-template-columns:1fr 340px;gap:2rem;align-items:start;">

    {{-- Formulaire --}}
    <div class="card">
        <div style="font-weight:800;margin-bottom:1.5rem;font-size:1rem;">Vos informations</div>
        <form method="POST" action="{{ route('orders.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Nom complet *</label>
                <input type="text" name="nom_client" class="form-control" required
                       value="{{ old('nom_client', auth()->user()->name ?? '') }}" placeholder="Votre nom complet">
                @error('nom_client')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Téléphone *</label>
                <input type="tel" name="telephone" class="form-control" required
                       value="{{ old('telephone') }}" placeholder="+261 34 00 000 00">
                @error('telephone')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email', auth()->user()->email ?? '') }}" placeholder="votre@email.mg">
            </div>
            <div class="form-group">
                <label class="form-label">Adresse *</label>
                <textarea name="adresse" class="form-control" rows="3" required
                          placeholder="Quartier, ville, région…">{{ old('adresse') }}</textarea>
                @error('adresse')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Notes (optionnel)</label>
                <textarea name="notes" class="form-control" rows="2"
                          placeholder="Instructions spéciales, heure de disponibilité…">{{ old('notes') }}</textarea>
            </div>
            <button type="submit" class="btn-primary" style="width:100%;justify-content:center;padding:0.9rem;font-size:1rem;">
                Confirmer la commande
            </button>
        </form>
    </div>

    {{-- Récapitulatif --}}
    <div style="position:sticky;top:80px;">
        <div class="card">
            <div style="font-weight:800;margin-bottom:1.25rem;font-size:1rem;">Récapitulatif</div>
            @foreach($cart->items as $item)
            <div style="display:flex;justify-content:space-between;font-size:0.85rem;margin-bottom:0.75rem;padding-bottom:0.75rem;border-bottom:1px solid var(--bg-border);">
                <div>
                    <div style="font-weight:600;">{{ Str::limit($item->voiture->titre, 25) }}</div>
                    <div style="font-size:0.75rem;color:var(--text-muted);">{{ $item->voiture->annee }} · Qté: {{ $item->quantite }}</div>
                </div>
                <div style="font-weight:700;color:var(--accent);white-space:nowrap;margin-left:0.5rem;">{{ $item->voiture->prix_formatte }}</div>
            </div>
            @endforeach
            <div style="display:flex;justify-content:space-between;align-items:center;margin-top:0.5rem;">
                <span style="font-weight:700;font-size:1rem;">Total</span>
                <span style="font-size:1.4rem;font-weight:900;color:var(--accent);">{{ $cart->total_formatte }}</span>
            </div>
            <div style="margin-top:1rem;font-size:0.78rem;color:var(--text-muted);line-height:1.7;">
                Un conseiller vous contactera après votre commande pour finaliser la transaction.
            </div>
        </div>
    </div>

    </div>
</div>
</div>
@endsection
