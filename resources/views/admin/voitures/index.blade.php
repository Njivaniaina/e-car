@extends('layouts.app')
@section('title', 'Admin — Voitures')
@section('content')
<div class="section">
<div class="container">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;">
        <h1 class="section-title">🚗 Gestion des <span class="heading-accent">Voitures</span></h1>
        <a href="{{ route('admin.voitures.create') }}" class="btn-primary">+ Ajouter</a>
    </div>

    <div class="card">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Voiture</th>
                    <th>Catégorie</th>
                    <th>Prix</th>
                    <th>État</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($voitures as $v)
                <tr>
                    <td>
                        <div style="font-weight:700;">{{ $v->titre }}</div>
                        <div style="font-size:0.75rem;color:var(--text-muted);">{{ $v->marque->nom }} · {{ $v->annee }}</div>
                    </td>
                    <td><span class="badge badge-cat">{{ $v->category->icone }} {{ $v->category->nom }}</span></td>
                    <td style="font-weight:700;color:var(--accent)">{{ $v->prix_formatte }}</td>
                    <td><span class="badge badge-{{ $v->etat }}">{{ ucfirst($v->etat) }}</span></td>
                    <td>
                        @if($v->is_active)
                        <span class="badge badge-success">Actif</span>
                        @else
                        <span class="badge badge-danger">Inactif</span>
                        @endif
                        @if($v->is_featured)
                        <span class="badge badge-warning" style="margin-left:0.3rem;">⭐ Vedette</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:0.5rem;">
                            <a href="{{ route('voitures.show', $v->slug) }}" class="btn-outline btn-sm">👁️</a>
                            <a href="{{ route('admin.voitures.edit', $v) }}" class="btn-outline btn-sm">✏️</a>
                            <form method="POST" action="{{ route('admin.voitures.destroy', $v) }}"
                                  onsubmit="return confirm('Supprimer cette voiture ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-danger btn-sm">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if($voitures->hasPages())
        <div class="pagination-wrap">
            @if(!$voitures->onFirstPage())
            <a href="{{ $voitures->previousPageUrl() }}" class="page-item">← Prec</a>
            @endif
            @foreach($voitures->getUrlRange(1, $voitures->lastPage()) as $page => $url)
            <a href="{{ $url }}" class="page-item {{ $voitures->currentPage() == $page ? 'active' : '' }}">{{ $page }}</a>
            @endforeach
            @if($voitures->hasMorePages())
            <a href="{{ $voitures->nextPageUrl() }}" class="page-item">Suiv →</a>
            @endif
        </div>
        @endif
    </div>
</div>
</div>
@endsection
