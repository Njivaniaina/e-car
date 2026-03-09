@extends('layouts.app')
@section('title', 'Admin — Commandes')
@section('content')
<div class="section">
<div class="container">
    <h1 class="section-title">Gestion des <span class="heading-accent">Commandes</span></h1>
    <p class="section-subtitle">{{ $commandes->total() }} commande(s) au total</p>

    <div class="card">
        @if($commandes->isEmpty())
        <p style="text-align:center; padding:2rem; color:var(--text-muted);">Aucune commande enregistrée.</p>
        @else
        <div class="table-responsive">
            <table class="data-table">
                ...
            </table>
        </div>
        <div style="margin-top:2rem;">
            {{ $commandes->links() }}
        </div>
        @endif
    </div>
</div>
</div>
@endsection
