<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Voiture extends Model
{
    protected $fillable = [
        'titre', 'slug', 'description', 'prix_ariary', 'annee',
        'kilometrage', 'etat', 'couleur', 'carburant', 'transmission',
        'places', 'puissance_cv', 'images', 'is_active', 'is_featured',
        'category_id', 'marque_id',
    ];

    protected $casts = [
        'images'      => 'array',
        'is_active'   => 'boolean',
        'is_featured' => 'boolean',
        'prix_ariary' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($voiture) {
            if (empty($voiture->slug)) {
                $voiture->slug = Str::slug($voiture->titre . '-' . $voiture->annee);
            }
        });
    }

    // ── Accessors ───────────────────────────────────────────────
    public function getPrixFormatteAttribute(): string
    {
        return number_format($this->prix_ariary, 0, ',', ' ') . ' Ar';
    }

    public function getPremierImageAttribute(): string
    {
        $images = $this->images ?? [];
        if (!empty($images)) {
            return asset('storage/' . $images[0]);
        }
        return asset('images/car-placeholder.jpg');
    }

    // ── Relations ───────────────────────────────────────────────
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function marque(): BelongsTo
    {
        return $this->belongsTo(Marque::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    // ── Scopes ──────────────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
