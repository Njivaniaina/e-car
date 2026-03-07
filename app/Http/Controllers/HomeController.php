<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Voiture;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $vedettes   = Voiture::active()->featured()->with(['category', 'marque'])->limit(6)->get();
        $recentes   = Voiture::active()->with(['category', 'marque'])->latest()->limit(8)->get();
        $categories = Category::withCount('voitures')->get();

        $stats = [
            'voitures'   => Voiture::active()->count(),
            'categories' => Category::count(),
            'marques'    => \App\Models\Marque::count(),
        ];

        return view('home', compact('vedettes', 'recentes', 'categories', 'stats'));
    }
}
