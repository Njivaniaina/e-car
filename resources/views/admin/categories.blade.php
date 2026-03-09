@extends('layouts.app')
@section('title', 'Admin — Catégories')
@section('content')
<div class="section">
<div class="container">
    <h1 class="section-title">Gestion des <span class="heading-accent">Catégories</span></h1>

    <div style="display:grid; grid-template-columns:350px 1fr; gap:2.5rem; align-items:start;">
        <div class="card">
            <div style="font-weight:800; margin-bottom:1.5rem; font-size:1rem;">Ajouter une catégorie</div>
            <form method="POST" action="{{ route('admin.categories.store') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nom de la catégorie *</label>
                    <input type="text" name="nom" class="form-control" required placeholder="ex: Camion">
                </div>
                <div class="form-group">
                    <label class="form-label">Icône (optionnel)</label>
                    <input type="text" name="icone" class="form-control" placeholder="ex: icon-car">
                </div>
                <button type="submit" class="btn-primary" style="width:100%; justify-content:center; padding:0.8rem;">Enregistrer</button>
            </form>
        </div>

        <div class="card">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width:50px;">Icon</th>
                        <th>Nom</th>
                        <th>Slug</th>
                        <th style="text-align:center;">Véhicules</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $cat)
                    <tr>
                        <td style="font-size:1.5rem; text-align:center;">{{ $cat->icone }}</td>
                        <td style="font-weight:700;">{{ $cat->nom }}</td>
                        <td style="font-family:monospace; font-size:0.82rem; color:var(--text-muted);">{{ $cat->slug }}</td>
                        <td style="text-align:center;">
                            <span class="badge badge-info">{{ $cat->voitures_count }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
@endsection
