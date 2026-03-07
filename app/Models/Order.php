<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'nom_client', 'telephone', 'adresse', 'email',
        'total_ariary', 'statut', 'notes', 'reference',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            if (empty($order->reference)) {
                $order->reference = 'CMD-' . strtoupper(uniqid());
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getTotalFormatteAttribute(): string
    {
        return number_format($this->total_ariary, 0, ',', ' ') . ' Ar';
    }

    public function getStatutLabelAttribute(): string
    {
        return match ($this->statut) {
            'en_attente' => 'En attente',
            'confirme'   => 'Confirmé',
            'en_cours'   => 'En cours',
            'livre'      => 'Livré',
            'annule'     => 'Annulé',
            default      => $this->statut,
        };
    }

    public function getStatutColorAttribute(): string
    {
        return match ($this->statut) {
            'en_attente' => 'orange',
            'confirme'   => 'blue',
            'en_cours'   => 'purple',
            'livre'      => 'green',
            'annule'     => 'red',
            default      => 'gray',
        };
    }
}
