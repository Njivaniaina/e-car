@extends('layouts.app')
@section('title', 'Admin — Ajouter une voiture')
@section('content')
<div class="section">
<div class="container" style="max-width:900px;">
    <div style="margin-bottom:2rem; display:flex; align-items:center; gap:1rem;">
        <a href="{{ route('admin.voitures') }}" class="btn-outline">← Retour</a>
        <h1 class="section-title">Ajouter une <span class="heading-accent">Voiture</span></h1>
    </div>

    <form method="POST" action="{{ route('admin.voitures.store') }}" enctype="multipart/form-data" class="card">
        @csrf
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem;">
            {{-- Infos de base --}}
            <div class="form-group">
                <label class="form-label">Titre de l'annonce *</label>
                <input type="text" name="titre" class="form-control" value="{{ old('titre') }}" required placeholder="ex: Toyota Corolla 2020">
                @error('titre')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Prix en Ariary *</label>
                <input type="number" name="prix_ariary" class="form-control" value="{{ old('prix_ariary') }}" required placeholder="ex: 45000000">
                @error('prix_ariary')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Année *</label>
                <input type="number" name="annee" class="form-control" value="{{ old('annee', date('Y')) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Kilométrage (km) *</label>
                <input type="number" name="kilometrage" class="form-control" value="{{ old('kilometrage', 0) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Catégorie *</label>
                <select name="category_id" class="form-control" required>
                    <option value="">Sélectionner—</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Marque *</label>
                <select name="marque_id" class="form-control" required>
                    <option value="">Sélectionner—</option>
                    @foreach($marques as $marque)
                    <option value="{{ $marque->id }}" {{ old('marque_id') == $marque->id ? 'selected' : '' }}>{{ $marque->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Carburant *</label>
                <select name="carburant" class="form-control" required>
                    <option value="essence">Essence</option>
                    <option value="diesel">Diesel</option>
                    <option value="electrique">Électrique</option>
                    <option value="hybride">Hybride</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Transmission *</label>
                <select name="transmission" class="form-control" required>
                    <option value="manuelle">Manuelle</option>
                    <option value="automatique">Automatique</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">État *</label>
                <select name="etat" class="form-control" required>
                    <option value="occasion">Occasion</option>
                    <option value="neuf">Neuf</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Couleur</label>
                <input type="text" name="couleur" class="form-control" value="{{ old('couleur') }}" placeholder="ex: Gris Métallisé">
            </div>

            <div class="form-group">
                <label class="form-label">Places</label>
                <input type="number" name="places" class="form-control" value="{{ old('places', 5) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Puissance (CV)</label>
                <input type="number" name="puissance_cv" class="form-control" value="{{ old('puissance_cv') }}">
            </div>
        </div>

        <div class="form-group" style="margin-top:1rem;">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" placeholder="Détails du véhicule, options, entretien...">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Images (plusieurs possibles)</label>
            <input type="file" name="images[]" class="form-control" multiple accept="image/*">
            <p style="font-size:0.75rem; color:var(--text-muted); margin-top:0.4rem;">Sélectionnez une ou plusieurs photos du véhicule.</p>
        </div>

        <div style="display:flex; gap:2rem; margin:1.5rem 0;">
            <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer;">
                <input type="checkbox" name="is_active" value="1" checked>
                <span style="font-size:0.9rem; font-weight:600;">Visible sur le site</span>
            </label>
            <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer;">
                <input type="checkbox" name="is_featured" value="1">
                <span style="font-size:0.9rem; font-weight:600;">Mettre en vedette (Featured)</span>
            </label>
        </div>

        <div style="padding-top:1rem; border-top:1px solid var(--bg-border);">
            <button type="submit" class="btn-primary" style="width:100%; justify-content:center; padding:0.9rem; font-size:1rem;">
                💾 Enregistrer la voiture
            </button>
        </div>
    </form>
</div>
</div>
@endsection
