@extends('layouts.app')

@section('title', $voiture->titre . ' — e-car')
@section('description', 'Achetez ' . $voiture->titre . ' à ' . $voiture->prix_formatte . ' en Ariary à Madagascar.')

@section('content')
<div class="section">
<div class="container">

{{-- Breadcrumb --}}
<div style="font-size:0.82rem;color:var(--text-muted);margin-bottom:1.5rem;">
    <a href="{{ route('home') }}" style="color:var(--text-muted)">Accueil</a>
    <span style="margin:0 0.4rem">›</span>
    <a href="{{ route('voitures.index') }}" style="color:var(--text-muted)">Voitures</a>
    <span style="margin:0 0.4rem">›</span>
    <span style="color:var(--text-white)">{{ $voiture->titre }}</span>
</div>

<div class="show-grid">

{{-- ── GAUCHE: Image + Specs ── --}}
<div>
    {{-- Image principale --}}
    <div style="background:var(--bg-card);border:1px solid var(--bg-border);border-radius:var(--radius);overflow:hidden;margin-bottom:1.5rem;">
        @if($voiture->images && count($voiture->images) > 0)
            <img src="{{ asset('storage/' . $voiture->images[0]) }}" alt="{{ $voiture->titre }}" class="main-img"
                 style="width:100%;height:clamp(250px, 40vh, 420px);object-fit:cover;">
            @if(count($voiture->images) > 1)
            <div style="display:flex;gap:0.5rem;padding:0.75rem;overflow-x:auto;">
                @foreach($voiture->images as $img)
                <img src="{{ asset('storage/' . $img) }}" alt="{{ $voiture->titre }}"
                     style="width:80px;height:60px;object-fit:cover;border-radius:6px;cursor:pointer;border:2px solid var(--bg-border);transition:border-color 0.2s"
                     onmouseover="document.querySelector('.main-img').src=this.src">
                @endforeach
            </div>
            @endif
        @else
            <div style="width:100%;height:420px;background:linear-gradient(135deg,#1a1a2e,#16213e);display:flex;align-items:center;justify-content:center;font-size:8rem;opacity:0.6;">
                {{ $voiture->category->icone ?? '' }}
            </div>
        @endif
    </div>

    {{-- Description --}}
    @if($voiture->description)
    <div class="card" style="margin-bottom:1.5rem;">
        <div style="font-weight:800;font-size:1rem;margin-bottom:0.75rem;">Description</div>
        <p style="color:var(--text-muted);line-height:1.8;font-size:0.94rem;">{{ $voiture->description }}</p>
    </div>
    @endif

    {{-- Specs techniques --}}
    <div class="card">
        <div style="font-weight:800;font-size:1rem;margin-bottom:1rem;">Caractéristiques techniques</div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.75rem;">
            @php
            $specs = [
                ['', 'Marque', $voiture->marque->nom],
                ['', 'Année', $voiture->annee],
                ['', 'Kilométrage', number_format($voiture->kilometrage,0,',',' ').' km'],
                ['', 'État', ucfirst($voiture->etat)],
                ['', 'Carburant', ucfirst($voiture->carburant)],
                ['', 'Transmission', ucfirst($voiture->transmission)],
                ['', 'Places', $voiture->places],
                ['', 'Couleur', $voiture->couleur ?? 'N/A'],
                ['', 'Puissance', $voiture->puissance_cv ? $voiture->puissance_cv.' CV' : 'N/A'],
                ['', 'Catégorie', $voiture->category->nom],
            ];
            @endphp
            @foreach($specs as $spec)
            <div style="background:var(--bg-hover,#16162a);border:1px solid var(--bg-border);border-radius:8px;padding:0.75rem;">
                <div style="font-size:0.75rem;color:var(--text-muted);margin-bottom:0.2rem;text-transform:uppercase;letter-spacing:0.3px;">{{ $spec[1] }}</div>
                <div style="font-weight:700;font-size:0.92rem;">{{ $spec[2] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>

        </div>
    </div>
</div>

<style>
    .show-grid { display: grid; grid-template-columns: 1fr 380px; gap: 2.5rem; align-items: start; }
    @media(max-width: 950px) {
        .show-grid { grid-template-columns: 1fr; gap: 1.5rem; }
        .sidebar-wrap { position: static !important; }
    }
</style>

</div>{{-- /grid --}}

{{-- ── VOITURES SIMILAIRES ── --}}
@if($similaires->isNotEmpty())
<div style="margin-top:3.5rem;">
    <h2 class="section-title" style="font-size:1.4rem;margin-bottom:1.5rem;">Voitures similaires</h2>
    <div class="grid-4">
        @foreach($similaires as $sim)
            @include('partials.voiture-card', ['voiture' => $sim])
        @endforeach
    </div>
</div>
@endif

</div>
</div>
@endsection
