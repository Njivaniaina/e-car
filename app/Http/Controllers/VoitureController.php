<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Marque;
use App\Models\Voiture;
use Illuminate\Http\Request;

class VoitureController extends Controller
{
    public function index(Request $request)
    {
        $query = Voiture::active()->with(['category', 'marque']);

        // Filtres
        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }
        if ($request->filled('marque')) {
            $query->whereHas('marque', fn($q) => $q->where('slug', $request->marque));
        }
        if ($request->filled('etat')) {
            $query->where('etat', $request->etat);
        }
        if ($request->filled('carburant')) {
            $query->where('carburant', $request->carburant);
        }
        if ($request->filled('prix_min')) {
            $query->where('prix_ariary', '>=', $request->prix_min);
        }
        if ($request->filled('prix_max')) {
            $query->where('prix_ariary', '<=', $request->prix_max);
        }
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('titre', 'like', '%' . $request->q . '%')
                  ->orWhere('description', 'like', '%' . $request->q . '%');
            });
        }

        // Tri
        $tri = $request->get('tri', 'recent');
        match ($tri) {
            'prix_asc'  => $query->orderBy('prix_ariary', 'asc'),
            'prix_desc' => $query->orderBy('prix_ariary', 'desc'),
            'annee'     => $query->orderBy('annee', 'desc'),
            default     => $query->latest(),
        };

        $voitures   = $query->paginate(12)->withQueryString();
        $categories = Category::all();
        $marques    = Marque::all();

        return view('voitures.index', compact('voitures', 'categories', 'marques'));
    }

    public function show(string $slug)
    {
        $voiture = Voiture::active()
            ->with(['category', 'marque'])
            ->where('slug', $slug)
            ->firstOrFail();

        $similaires = Voiture::active()
            ->where('category_id', $voiture->category_id)
            ->where('id', '!=', $voiture->id)
            ->with(['category', 'marque'])
            ->limit(4)
            ->get();

        return view('voitures.show', compact('voiture', 'similaires'));
    }
}
