<?php

namespace Database\Seeders;

use App\Models\Marque;
use Illuminate\Database\Seeder;

class MarqueSeeder extends Seeder
{
    public function run(): void
    {
        $marques = [
            ['nom' => 'Toyota',     'slug' => 'toyota',     'pays_origine' => 'Japon'],
            ['nom' => 'Mitsubishi', 'slug' => 'mitsubishi', 'pays_origine' => 'Japon'],
            ['nom' => 'Nissan',     'slug' => 'nissan',     'pays_origine' => 'Japon'],
            ['nom' => 'Honda',      'slug' => 'honda',      'pays_origine' => 'Japon'],
            ['nom' => 'BMW',        'slug' => 'bmw',        'pays_origine' => 'Allemagne'],
            ['nom' => 'Mercedes',   'slug' => 'mercedes',   'pays_origine' => 'Allemagne'],
            ['nom' => 'Renault',    'slug' => 'renault',    'pays_origine' => 'France'],
            ['nom' => 'Peugeot',    'slug' => 'peugeot',    'pays_origine' => 'France'],
            ['nom' => 'Hyundai',    'slug' => 'hyundai',    'pays_origine' => 'Corée du Sud'],
            ['nom' => 'Ford',       'slug' => 'ford',       'pays_origine' => 'États-Unis'],
            ['nom' => 'Isuzu',      'slug' => 'isuzu',      'pays_origine' => 'Japon'],
            ['nom' => 'Suzuki',     'slug' => 'suzuki',     'pays_origine' => 'Japon'],
        ];

        foreach ($marques as $marque) {
            Marque::firstOrCreate(['slug' => $marque['slug']], $marque);
        }
    }
}
