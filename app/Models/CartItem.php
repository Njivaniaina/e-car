<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $fillable = ['cart_id', 'voiture_id', 'quantite'];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function voiture(): BelongsTo
    {
        return $this->belongsTo(Voiture::class);
    }

    public function getSousTotalAttribute(): int
    {
        return $this->voiture->prix_ariary * $this->quantite;
    }

    public function getSousTotalFormatteAttribute(): string
    {
        return number_format($this->sous_total, 0, ',', ' ') . ' Ar';
    }
}
