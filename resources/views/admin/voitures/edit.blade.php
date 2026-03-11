@extends('layouts.app')
@section('title', 'Admin — Modifier ' . $voiture->titre)
@section('content')
<div class="section">
<div class="container" style="max-width:900px;">
    <div style="margin-bottom:2rem; display:flex; align-items:center; gap:1rem;">
        <a href="{{ route('admin.voitures') }}" class="btn-outline">← Retour</a>
        <h1 class="section-title">Modifier <span class="heading-accent">{{ $voiture->titre }}</span></h1>
    </div>

    <form method="POST" action="{{ route('admin.voitures.update', $voiture) }}" enctype="multipart/form-data" class="card">
        @csrf
        @method('PUT')
        <div class="grid-2">
            {{-- Infos de base --}}
            <div class="form-group">
                <label class="form-label">Titre de l'annonce *</label>
                <input type="text" name="titre" class="form-control" value="{{ old('titre', $voiture->titre) }}" required>
                @error('titre')<div class="form-error">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <label class="form-label">Prix en Ariary *</label>
                <input type="number" name="prix_ariary" class="form-control" value="{{ old('prix_ariary', $voiture->prix_ariary) }}" required>
                @error('prix_ariary')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">Année *</label>
                <input type="number" name="annee" class="form-control" value="{{ old('annee', $voiture->annee) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Kilométrage (km) *</label>
                <input type="number" name="kilometrage" class="form-control" value="{{ old('kilometrage', $voiture->kilometrage) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Catégorie *</label>
                <select name="category_id" class="form-control" required>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $voiture->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Marque *</label>
                <select name="marque_id" class="form-control" required>
                    @foreach($marques as $marque)
                    <option value="{{ $marque->id }}" {{ old('marque_id', $voiture->marque_id) == $marque->id ? 'selected' : '' }}>{{ $marque->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Carburant *</label>
                <select name="carburant" class="form-control" required>
                    @foreach(['essence','diesel','electrique','hybride'] as $c)
                    <option value="{{ $c }}" {{ old('carburant', $voiture->carburant) == $c ? 'selected' : '' }}>{{ ucfirst($c) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Transmission *</label>
                <select name="transmission" class="form-control" required>
                    <option value="manuelle" {{ old('transmission', $voiture->transmission) == 'manuelle' ? 'selected' : '' }}>Manuelle</option>
                    <option value="automatique" {{ old('transmission', $voiture->transmission) == 'automatique' ? 'selected' : '' }}>Automatique</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">État *</label>
                <select name="etat" class="form-control" required>
                    <option value="occasion" {{ old('etat', $voiture->etat) == 'occasion' ? 'selected' : '' }}>Occasion</option>
                    <option value="neuf" {{ old('etat', $voiture->etat) == 'neuf' ? 'selected' : '' }}>Neuf</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Couleur</label>
                <input type="text" name="couleur" class="form-control" value="{{ old('couleur', $voiture->couleur) }}">
            </div>

            <div class="form-group">
                <label class="form-label">Places</label>
                <input type="number" name="places" class="form-control" value="{{ old('places', $voiture->places) }}">
            </div>
            <div class="form-group">
                <label class="form-label">Puissance (CV)</label>
                <input type="number" name="puissance_cv" class="form-control" value="{{ old('puissance_cv', $voiture->puissance_cv) }}">
            </div>
        </div>

        <div class="form-group" style="margin-top:1rem;">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description', $voiture->description) }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Ajouter des images</label>
            <input type="file" name="images[]" class="form-control" multiple accept="image/*">
            <p style="font-size:0.75rem; color:var(--text-muted); margin-top:0.4rem;">Laissez vide pour conserver les images actuelles.</p>
        </div>

        @if($voiture->images)
        <div style="display:flex; gap:0.5rem; flex-wrap:wrap; margin-bottom:1.5rem;">
            @foreach($voiture->images as $img)
            <div style="position:relative;">
                <img src="{{ asset('storage/'.$img) }}" style="width:100px; height:80px; object-fit:cover; border-radius:6px;">
            </div>
            @endforeach
        </div>
        @endif

        <div style="display:flex; gap:2rem; margin:1.5rem 0;">
            <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer;">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $voiture->is_active) ? 'checked' : '' }}>
                <span style="font-size:0.9rem; font-weight:600;">Visible sur le site</span>
            </label>
            <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer;">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $voiture->is_featured) ? 'checked' : '' }}>
                <span style="font-size:0.9rem; font-weight:600;">Mettre en vedette (Featured)</span>
            </label>
        </div>

        <div style="padding-top:1rem; border-top:1px solid var(--bg-border);">
            <button type="submit" class="btn-primary" style="width:100%; justify-content:center; padding:0.9rem; font-size:1rem;">
                Mettre à jour la voiture
            </button>
        </div>
    </form>
</div>
</div>
@endsection
