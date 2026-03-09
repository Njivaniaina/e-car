@extends('layouts.app')
@section('title', 'Détails Commande ' . $order->reference)
@section('content')
<div class="section">
<div class="container" style="max-width:900px;">
    <div style="margin-bottom:2rem; display:flex; align-items:center; gap:1rem;">
        <a href="{{ route('admin.commandes') }}" class="btn-outline">← Retour</a>
        <h1 class="section-title">Commande <span class="heading-accent">{{ $order->reference }}</span></h1>
    </div>

    <div style="display:grid; grid-template-columns:1fr 320px; gap:2rem; align-items:start;">
        <div>
            {{-- Client & Livraison --}}
            <div class="card" style="margin-bottom:1.5rem;">
                <div style="font-weight:800; margin-bottom:1rem; font-size:1rem; border-bottom:1px solid var(--bg-border); padding-bottom:0.5rem;">Infos Client</div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; font-size:0.92rem;">
                    <div>
                        <div style="color:var(--text-muted); font-size:0.75rem; text-transform:uppercase;">Nom</div>
                        <div style="font-weight:600;">{{ $order->nom_client }}</div>
                    </div>
                    <div>
                        <div style="color:var(--text-muted); font-size:0.75rem; text-transform:uppercase;">Téléphone</div>
                        <div style="font-weight:600; color:var(--accent);">{{ $order->telephone }}</div>
                    </div>
                    <div style="grid-column: span 2;">
                        <div style="color:var(--text-muted); font-size:0.75rem; text-transform:uppercase;">Adresse</div>
                        <div style="font-weight:600;">{{ $order->adresse }}</div>
                    </div>
                    @if($order->email)
                    <div style="grid-column: span 2;">
                        <div style="color:var(--text-muted); font-size:0.75rem; text-transform:uppercase;">Email</div>
                        <div>{{ $order->email }}</div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Articles --}}
            <div class="card">
                <div style="font-weight:800; margin-bottom:1rem; font-size:1rem; border-bottom:1px solid var(--bg-border); padding-bottom:0.5rem;">Articles</div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Véhicule</th>
                            <th style="text-align:right;">Prix Unitaire</th>
                            <th style="text-align:center;">Qté</th>
                            <th style="text-align:right;">Sous-total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                <div style="font-weight:700;">{{ $item->titre_voiture }}</div>
                                @if($item->voiture)
                                <a href="{{ route('voitures.show', $item->voiture->slug) }}" style="font-size:0.75rem; color:var(--accent);">Voir fiche →</a>
                                @endif
                            </td>
                            <td style="text-align:right;">{{ number_format($item->prix_ariary, 0, ',', ' ') }} Ar</td>
                            <td style="text-align:center;">{{ $item->quantite }}</td>
                            <td style="text-align:right; font-weight:700; color:var(--accent);">{{ number_format($item->sous_total, 0, ',', ' ') }} Ar</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="text-align:right; font-weight:800; padding:1.5rem 1rem;">TOTAL</td>
                            <td style="text-align:right; font-size:1.4rem; font-weight:900; color:var(--accent); padding:1.5rem 1rem;">{{ $order->total_formatte }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            @if($order->notes)
            <div class="card" style="margin-top:1.5rem; border-left:4px solid var(--accent);">
                <div style="font-weight:700; font-size:0.85rem; color:var(--text-muted); margin-bottom:0.4rem;">Notes du client :</div>
                <p style="font-size:0.92rem; font-style:italic;">"{{ $order->notes }}"</p>
            </div>
            @endif
        </div>

        {{-- Barre latérale: Statut --}}
        <div style="position:sticky; top:80px;">
            <div class="card">
                <div style="font-weight:800; margin-bottom:1.5rem; font-size:1rem;">Action</div>
                <div style="margin-bottom:1.5rem;">
                    <div style="color:var(--text-muted); font-size:0.75rem; text-transform:uppercase; margin-bottom:0.5rem;">Statut actuel</div>
                    <span class="badge badge-{{ $order->statut_color }}" style="font-size:1rem; padding:0.5rem 1rem;">{{ $order->statut_label }}</span>
                </div>

                <form method="POST" action="{{ route('admin.commandes.statut', $order) }}">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label class="form-label">Changer le statut</label>
                        <select name="statut" class="form-control" onchange="this.form.submit()">
                            @foreach(['en_attente','confirme','en_cours','livre','annule'] as $st)
                            <option value="{{ $st }}" {{ $order->statut == $st ? 'selected' : '' }}>
                                {{ match($st){'en_attente'=>'En attente','confirme'=>'Confirmé','en_cours'=>'En cours','livre'=>'Livré','annule'=>'Annulé'} }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </form>

                <p style="font-size:0.78rem; color:var(--text-muted); margin-top:2rem; line-height:1.6;">
                    La modification du statut informe le système de l'avancement de la vente.
                </p>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
