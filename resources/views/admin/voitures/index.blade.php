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
                ...
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
