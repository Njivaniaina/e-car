<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Marque extends Model
{
    protected $fillable = ['nom', 'slug', 'logo', 'pays_origine'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($marque) {
            if (empty($marque->slug)) {
                $marque->slug = Str::slug($marque->nom);
            }
        });
    }

    public function voitures(): HasMany
    {
        return $this->hasMany(Voiture::class);
    }
}
