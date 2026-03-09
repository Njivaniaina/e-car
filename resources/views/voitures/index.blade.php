@extends('layouts.app')

@section('title', 'Catalogue Voitures — E-Mobile')
@section('description', 'Parcourez notre catalogue de voitures neuves et d\'occasion à Madagascar, prix en Ariary.')

@section('content')
<div class="section">
<div class="container">

{{-- HEADER --}}
<div style="margin-bottom:2rem;">
    <h1 class="section-title">Catalogue <span class="heading-accent">Voitures</span></h1>
    <p class="section-subtitle">{{ $voitures->total() }} véhicule{{ $voitures->total() > 1 ? 's' : '' }} disponible{{ $voitures->total() > 1 ? 's' : '' }}</p>
</div>

<div style="display:grid;grid-template-columns:280px 1fr;gap:2rem;align-items:start;">

{{-- ── SIDEBAR FILTRES ── --}}
<aside>
    <form method="GET" action="{{ route('voitures.index') }}">
        <div class="card" style="position:sticky;top:80px;">
            <div style="font-weight:800;font-size:1rem;margin-bottom:1.25rem;">Filtres</div>

            @if(request()->hasAny(['category','marque','etat','carburant','prix_min','prix_max','q']))
            <a href="{{ route('voitures.index') }}" class="btn-outline btn-sm" style="display:block;text-align:center;margin-bottom:1.25rem;color:var(--danger);border-color:rgba(239,68,68,0.3);">
                ✕ Effacer les filtres
            </a>
            @endif

            {{-- Recherche --}}
            <div class="form-group">
                <label class="form-label">Recherche</label>
                <input type="text" name="q" class="form-control" placeholder="Marque, modèle…" value="{{ request('q') }}">
            </div>

            {{-- Catégorie --}}
            <div class="form-group">
                <label class="form-label">Catégorie</label>
                <select name="category" class="form-control">
                    <option value="">Toutes</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                        {{ $cat->icone }} {{ $cat->nom }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Marque --}}
            <div class="form-group">
                <label class="form-label">Marque</label>
                <select name="marque" class="form-control">
                    <option value="">Toutes</option>
                    @foreach($marques as $marque)
                    <option value="{{ $marque->slug }}" {{ request('marque') == $marque->slug ? 'selected' : '' }}>
                        {{ $marque->nom }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- État --}}
            <div class="form-group">
                <label class="form-label">État</label>
                <select name="etat" class="form-control">
                    <option value="">Tous</option>
                    <option value="neuf" {{ request('etat') === 'neuf' ? 'selected' : '' }}>✨ Neuf</option>
                    <option value="occasion" {{ request('etat') === 'occasion' ? 'selected' : '' }}>Occasion</option>
                </select>
            </div>

            {{-- Carburant --}}
            <div class="form-group">
                <label class="form-label">Carburant</label>
                <select name="carburant" class="form-control">
                    <option value="">Tous</option>
                    <option value="essence"     {{ request('carburant') === 'essence'     ? 'selected' : '' }}>Essence</option>
                    <option value="diesel"      {{ request('carburant') === 'diesel'      ? 'selected' : '' }}>Diesel</option>
                    <option value="electrique"  {{ request('carburant') === 'electrique'  ? 'selected' : '' }}>Électrique</option>
                    <option value="hybride"     {{ request('carburant') === 'hybride'     ? 'selected' : '' }}>Hybride</option>
                </select>
            </div>

            {{-- Prix --}}
            <div class="form-group">
                <label class="form-label">Prix min (Ar)</label>
                <input type="number" name="prix_min" class="form-control" placeholder="ex: 10 000 000" value="{{ request('prix_min') }}" step="1000000">
            </div>
            <div class="form-group">
                <label class="form-label">Prix max (Ar)</label>
                <input type="number" name="prix_max" class="form-control" placeholder="ex: 100 000 000" value="{{ request('prix_max') }}" step="1000000">
            </div>

            {{-- Tri --}}
            <div class="form-group">
                <label class="form-label">Trier par</label>
                <select name="tri" class="form-control">
                    <option value="recent"    {{ request('tri', 'recent') === 'recent'    ? 'selected' : '' }}>Plus récent</option>
                    <option value="prix_asc"  {{ request('tri') === 'prix_asc'            ? 'selected' : '' }}>Prix croissant</option>
                    <option value="prix_desc" {{ request('tri') === 'prix_desc'           ? 'selected' : '' }}>Prix décroissant</option>
                    <option value="annee"     {{ request('tri') === 'annee'               ? 'selected' : '' }}>Année récente</option>
                </select>
            </div>

            <button type="submit" class="btn-primary" style="width:100%;justify-content:center;">Appliquer</button>
        </div>
    </form>
</aside>

{{-- ── RÉSULTATS ── --}}
<div>
    @if($voitures->isEmpty())
    <div style="text-align:center;padding:4rem 0;">
        <div style="font-size:4rem;margin-bottom:1rem;"></div>
        <div style="font-size:1.2rem;font-weight:700;margin-bottom:0.5rem;">Aucun résultat</div>
        <p style="color:var(--text-muted);">Essayez d'autres filtres.</p>
        <a href="{{ route('voitures.index') }}" class="btn-primary" style="margin-top:1.5rem;display:inline-flex;">Réinitialiser</a>
    </div>
    @else
    <div class="grid-3" style="grid-template-columns:repeat(3,1fr);">
        @foreach($voitures as $voiture)
            @include('partials.voiture-card', ['voiture' => $voiture])
        @endforeach
    </div>

    {{-- PAGINATION --}}
    @if($voitures->hasPages())
    <div class="pagination-wrap">
        @if($voitures->onFirstPage())
            <span class="page-item" style="opacity:0.4;">← Prec</span>
        @else
            <a href="{{ $voitures->previousPageUrl() }}" class="page-item">← Prec</a>
        @endif

        @foreach($voitures->getUrlRange(1, $voitures->lastPage()) as $page => $url)
            <a href="{{ $url }}" class="page-item {{ $voitures->currentPage() == $page ? 'active' : '' }}">{{ $page }}</a>
        @endforeach

        @if($voitures->hasMorePages())
            <a href="{{ $voitures->nextPageUrl() }}" class="page-item">Suiv →</a>
        @else
            <span class="page-item" style="opacity:0.4;">Suiv →</span>
        @endif
    </div>
    @endif
    @endif
</div>

</div>{{-- /grid --}}
</div>
</div>
@endsection
