<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    protected $fillable = ['user_id', 'session_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function getTotalAttribute(): int
    {
        return $this->items->sum(fn($item) => $item->voiture->prix_ariary * $item->quantite);
    }

    public function getTotalFormatteAttribute(): string
    {
        return number_format($this->total, 0, ',', ' ') . ' Ar';
    }

    public function getNombreItemsAttribute(): int
    {
        return $this->items->sum('quantite');
    }
}
