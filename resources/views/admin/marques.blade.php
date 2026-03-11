@extends('layouts.app')
@section('title', 'Admin — Marques')
@section('content')
<div class="section">
<div class="container">
    <h1 class="section-title">Gestion des <span class="heading-accent">Marques</span></h1>

    <div class="grid-admin-custom">
        <div class="card">
            <div style="font-weight:800; margin-bottom:1.5rem; font-size:1rem;">➕ Ajouter une marque</div>
            <form method="POST" action="{{ route('admin.marques.store') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nom de la marque *</label>
                    <input type="text" name="nom" class="form-control" required placeholder="ex: Isuzu">
                </div>
                <div class="form-group">
                    <label class="form-label">Pays d'origine</label>
                    <input type="text" name="pays_origine" class="form-control" placeholder="ex: Japon">
                </div>
                <button type="submit" class="btn-primary" style="width:100%; justify-content:center; padding:0.8rem;">Enregistrer</button>
            </form>
        </div>

        <div class="card">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Slug</th>
                            <th>Pays d'origine</th>
                            <th style="text-align:center;">Véhicules</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($marques as $m)
                        <tr>
                            <td style="font-weight:700;">{{ $m->nom }}</td>
                            <td style="font-family:monospace; font-size:0.82rem; color:var(--text-muted);">{{ $m->slug }}</td>
                            <td>{{ $m->pays_origine ?? 'N/A' }}</td>
                            <td style="text-align:center;">
                                <span class="badge badge-info">{{ $m->voitures_count }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
