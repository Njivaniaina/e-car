{{-- Partial: carte voiture réutilisable --}}
<div class="car-card">
    <a href="{{ route('voitures.show', $voiture->slug) }}" style="display:block;overflow:hidden;">
        @if($voiture->images && count($voiture->images) > 0)
            <img src="{{ asset('storage/' . $voiture->images[0]) }}" alt="{{ $voiture->titre }}" class="car-card-img"
                 style="transition:transform 0.4s" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform=''">
        @else
            <div class="car-card-img-ph">{{ $voiture->category->icone ?? '' }}</div>
        @endif
    </a>
    <div class="car-card-body">
        <div style="display:flex;gap:0.4rem;flex-wrap:wrap;margin-bottom:0.5rem;">
            <span class="badge badge-{{ $voiture->etat }}">{{ $voiture->etat === 'neuf' ? 'Neuf' : 'Occasion' }}</span>
            <span class="badge badge-cat">{{ $voiture->category->icone ?? '' }} {{ $voiture->category->nom }}</span>
        </div>
        <div class="car-card-title">
            <a href="{{ route('voitures.show', $voiture->slug) }}" style="color:inherit;">{{ $voiture->titre }}</a>
        </div>
        <div class="car-card-meta">
            <span>Année : {{ $voiture->annee }}</span>
            @if($voiture->kilometrage > 0)
            <span>{{ number_format($voiture->kilometrage, 0, ',', ' ') }} km</span>
            @else
            <span>0 km</span>
            @endif
            <span>{{ ucfirst($voiture->carburant) }}</span>
            <span>{{ ucfirst($voiture->transmission) }}</span>
        </div>
        <div class="car-card-price">{{ $voiture->prix_formatte }}</div>
        <div class="car-card-footer">
            <a href="{{ route('voitures.show', $voiture->slug) }}" class="btn-outline btn-sm" style="flex:1;justify-content:center;">Voir détails</a>
            <form method="POST" action="{{ route('cart.ajouter') }}" style="flex:1">
                @csrf
                <input type="hidden" name="voiture_id" value="{{ $voiture->id }}">
                <button type="submit" class="btn-primary btn-sm" style="width:100%;justify-content:center;">Ajouter</button>
            </form>
        </div>
    </div>
</div>
