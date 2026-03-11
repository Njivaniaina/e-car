@extends('layouts.app')
@section('title', 'Admin — Voitures')
@section('content')
<div class="section">
<div class="container">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:2rem;">
        <h1 class="section-title">Gestion des <span class="heading-accent">Voitures</span></h1>
        <a href="{{ route('admin.voitures.create') }}" class="btn-primary">+ Ajouter</a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width:80px;">Image</th>
                        <th>Vignette / Titre</th>
                        <th>Prix</th>
                        <th>Marque / Cat</th>
                        <th>Statut</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($voitures as $v)
                    <tr>
                        <td>
                            <img src="{{ $v->premier_image }}" style="width:60px; height:45px; object-fit:cover; border-radius:4px;">
                        </td>
                        <td>
                            <div style="font-weight:700;">{{ $v->titre }}</div>
                            <div style="font-size:0.75rem; color:var(--text-muted)">{{ $v->annee }} — {{ $v->kilometrage }} km</div>
                        </td>
                        <td style="font-weight:700; color:var(--accent)">{{ $v->prix_formatte }}</td>
                        <td>
                            <div style="font-size:0.85rem;">{{ $v->marque->nom ?? 'N/A' }}</div>
                            <div class="badge badge-cat">{{ $v->category->nom ?? 'N/A' }}</div>
                        </td>
                        <td>
                            @if($v->is_active)
                                <span class="badge badge-success">Actif</span>
                            @else
                                <span class="badge badge-danger">Inactif</span>
                            @endif
                        </td>
                        <td style="text-align:right;">
                            <div style="display:flex; gap:0.5rem; justify-content:flex-end;">
                                <a href="{{ route('admin.voitures.edit', $v) }}" class="btn-outline btn-sm">Modifier</a>
                                <form action="{{ route('admin.voitures.destroy', $v) }}" method="POST" onsubmit="return confirm('Supprimer cette voiture ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-danger btn-sm">Suppr</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

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
