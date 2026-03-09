<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['nom' => 'Berline',   'slug' => 'berline',   'icone' => null, 'description' => 'Voitures de type berline, confortables et élégantes'],
            ['nom' => 'SUV',       'slug' => 'suv',       'icone' => null, 'description' => 'Sport Utility Vehicle, idéal pour tout terrain'],
            ['nom' => 'Pickup',    'slug' => 'pickup',    'icone' => null, 'description' => 'Camionnette pickup polyvalente'],
            ['nom' => 'Citadine',  'slug' => 'citadine',  'icone' => null, 'description' => 'Petite voiture parfaite pour la ville'],
            ['nom' => 'Camion',    'slug' => 'camion',    'icone' => null, 'description' => 'Camions utilitaires et de transport'],
            ['nom' => 'Monospace', 'slug' => 'monospace', 'icone' => null, 'description' => 'Grande capacité passagers, idéal pour la famille'],
            ['nom' => 'Coupé',     'slug' => 'coupe',     'icone' => null, 'description' => 'Voitures sportives et design'],
            ['nom' => 'Moto',      'slug' => 'moto',      'icone' => null, 'description' => 'Motos et deux-roues motorisées'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
