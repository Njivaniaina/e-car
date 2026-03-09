@extends('layouts.app')

@section('title', 'e-car — Vente de Voitures Madagascar')
@section('description', 'Trouvez votre voiture idéale en Ariary. Berlines, SUV, Pickups neufs et d\'occasion à Madagascar.')

@section('content')

{{-- ── HERO ── --}}
<section style="background: linear-gradient(135deg, #0a0a0f 0%, #12121a 50%, #0f0a00 100%); padding: 6rem 0 5rem; position:relative; overflow:hidden;">
    <div style="position:absolute;inset:0;background:radial-gradient(ellipse 80% 60% at 60% 50%, rgba(232,160,0,0.08), transparent);pointer-events:none"></div>
    <div style="position:absolute;top:20%;right:5%;font-size:12rem;opacity:0.04;pointer-events:none;line-height:1"></div>
    <div class="container" style="position:relative">
        <div style="max-width:640px">
            <div style="display:inline-flex;align-items:center;gap:0.5rem;background:rgba(232,160,0,0.1);border:1px solid rgba(232,160,0,0.2);border-radius:50px;padding:0.35rem 1rem;font-size:0.82rem;font-weight:600;color:var(--accent);margin-bottom:1.5rem;">
                N°1 à Madagascar
            </div>
            <h1 style="font-size:clamp(1.8rem,8vw,3.8rem);font-weight:900;line-height:1.1;margin-bottom:1.25rem;">
                Trouvez votre<br><span style="color:var(--accent)">voiture idéale</span><br>en Ariary
            </h1>
            <p style="font-size:1.05rem;color:var(--text-muted);margin-bottom:2.5rem;max-width:480px;line-height:1.75;">
                {{ $stats['voitures'] }} voitures disponibles — neuves et d'occasion — {{ $stats['categories'] }} catégories, {{ $stats['marques'] }} marques.
            </p>
            <div style="display:flex;gap:0.75rem;flex-wrap:wrap;">
                <a href="{{ route('voitures.index') }}" class="btn-primary" style="flex:1;min-width:200px;justify-content:center;padding:0.75rem 1rem;">
                    Catalogue complet
                </a>
                <a href="{{ route('voitures.index') }}?etat=neuf" class="btn-outline" style="flex:1;min-width:200px;justify-content:center;padding:0.75rem 1rem;">
                    Voitures neuves
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ── STATS ── --}}
<section style="background:var(--bg-card);border-bottom:1px solid var(--bg-border);">
    <div class="container" style="padding:2rem 1.5rem;">
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;text-align:center;">
            <div>
                <div style="font-size:2.5rem;font-weight:900;color:var(--accent);">{{ $stats['voitures'] }}</div>
                <div style="font-size:0.85rem;color:var(--text-muted);margin-top:0.2rem;">Voitures disponibles</div>
            </div>
            <div>
                <div style="font-size:2.5rem;font-weight:900;color:var(--accent);">{{ $stats['marques'] }}</div>
                <div style="font-size:0.85rem;color:var(--text-muted);margin-top:0.2rem;">Marques</div>
            </div>
            <div>
                <div style="font-size:2.5rem;font-weight:900;color:var(--accent);">{{ $stats['categories'] }}</div>
                <div style="font-size:0.85rem;color:var(--text-muted);margin-top:0.2rem;">Catégories</div>
            </div>
        </div>
    </div>
</section>

{{-- ── CATEGORIES ── --}}
<section class="section">
    <div class="container">
        <h2 class="section-title">Parcourir par <span class="heading-accent">catégorie</span></h2>
        <p class="section-subtitle">Trouvez le véhicule qui correspond à vos besoins</p>
        <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(140px, 1fr));gap:0.75rem;">
            @foreach($categories as $cat)
            <a href="{{ route('voitures.index') }}?category={{ $cat->slug }}"
               style="background:var(--bg-card);border:1px solid var(--bg-border);border-radius:var(--radius);padding:1rem 0.5rem;text-align:center;transition:all 0.3s;display:block;"
               onmouseover="this.style.borderColor='rgba(232,160,0,0.4)';this.style.transform='translateY(-3px)'"
               onmouseout="this.style.borderColor='var(--bg-border)';this.style.transform=''">
                <div style="font-weight:700;font-size:0.85rem;">{{ $cat->nom }}</div>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:0.1rem;">{{ $cat->voitures_count }} véhicule{{ $cat->voitures_count > 1 ? 's' : '' }}</div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ── VOITURES VEDETTES ── --}}
@if($vedettes->isNotEmpty())
<section class="section" style="background:var(--bg-card);border-top:1px solid var(--bg-border);border-bottom:1px solid var(--bg-border);">
    <div class="container">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;">
            <div>
                <h2 class="section-title" style="margin-bottom:0.2rem;">Voitures <span class="heading-accent">en vedette</span></h2>
                <p style="font-size:0.9rem;color:var(--text-muted);">Sélection premium de nos meilleurs véhicules</p>
            </div>
            <a href="{{ route('voitures.index') }}" class="btn-outline">Voir tout →</a>
        </div>
        <div class="grid-3">
            @foreach($vedettes as $voiture)
                @include('partials.voiture-card', ['voiture' => $voiture])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ── RECENTES ── --}}
@if($recentes->isNotEmpty())
<section class="section">
    <div class="container">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;">
            <div>
                <h2 class="section-title" style="margin-bottom:0.2rem;">Dernières <span class="heading-accent">annonces</span></h2>
                <p style="font-size:0.9rem;color:var(--text-muted);">Les voitures récemment ajoutées</p>
            </div>
            <a href="{{ route('voitures.index') }}" class="btn-outline">Voir tout →</a>
        </div>
        <div class="grid-4">
            @foreach($recentes as $voiture)
                @include('partials.voiture-card', ['voiture' => $voiture])
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ── CTA ── --}}
<section style="background:linear-gradient(135deg,rgba(232,160,0,0.08),rgba(232,160,0,0.02));border-top:1px solid var(--bg-border);padding:5rem 0;text-align:center;">
    <div class="container">
        <div style="font-size:3rem;margin-bottom:1rem;"></div>
        <h2 style="font-size:2rem;font-weight:900;margin-bottom:0.75rem;">Prêt à trouver votre voiture ?</h2>
        <p style="font-size:1rem;color:var(--text-muted);margin-bottom:2rem;max-width:450px;margin-left:auto;margin-right:auto;">
            Parcourez notre catalogue complet avec filtres avancés par prix, marque, catégorie et plus encore.
        </p>
        <a href="{{ route('voitures.index') }}" class="btn-primary" style="font-size:1rem;padding:0.85rem 2.5rem;">
            Parcourir le catalogue
        </a>
    </div>
</section>

@endsection
