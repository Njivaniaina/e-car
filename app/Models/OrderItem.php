<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'voiture_id', 'titre_voiture', 'prix_ariary', 'quantite',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function voiture(): BelongsTo
    {
        return $this->belongsTo(Voiture::class);
    }

    public function getPrixFormatteAttribute(): string
    {
        return number_format($this->prix_ariary, 0, ',', ' ') . ' Ar';
    }

    public function getSousTotalAttribute(): int
    {
        return $this->prix_ariary * $this->quantite;
    }
}
