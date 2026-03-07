<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Marque;
use App\Models\Order;
use App\Models\Voiture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // ── Dashboard ─────────────────────────────────────────────
    public function dashboard()
    {
        $stats = [
            'voitures'        => Voiture::count(),
            'voitures_active' => Voiture::active()->count(),
            'commandes'       => Order::count(),
            'en_attente'      => Order::where('statut', 'en_attente')->count(),
            'revenu'          => Order::whereIn('statut', ['confirme', 'livre'])->sum('total_ariary'),
        ];

        $dernieres_commandes = Order::with('items')->latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'dernieres_commandes'));
    }

    // ── Voitures ─────────────────────────────────────────────
    public function voitures()
    {
        $voitures = Voiture::with(['category', 'marque'])->latest()->paginate(15);
        return view('admin.voitures.index', compact('voitures'));
    }

    public function voitureCreate()
    {
        $categories = Category::all();
        $marques    = Marque::all();
        return view('admin.voitures.create', compact('categories', 'marques'));
    }

    public function voitureStore(Request $request)
    {
        $validated = $request->validate([
            'titre'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'prix_ariary'  => 'required|integer|min:0',
            'annee'        => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'kilometrage'  => 'required|integer|min:0',
            'etat'         => 'required|in:neuf,occasion',
            'couleur'      => 'nullable|string|max:50',
            'carburant'    => 'required|in:essence,diesel,electrique,hybride',
            'transmission' => 'required|in:manuelle,automatique',
            'places'       => 'required|integer|min:1|max:20',
            'puissance_cv' => 'nullable|integer',
            'category_id'  => 'required|exists:categories,id',
            'marque_id'    => 'required|exists:marques,id',
            'is_active'    => 'boolean',
            'is_featured'  => 'boolean',
            'images.*'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('voitures', 'public');
                $images[] = $path;
            }
        }

        $slug = Str::slug($validated['titre'] . '-' . $validated['annee']);
        $slug = Voiture::where('slug', $slug)->exists() ? $slug . '-' . uniqid() : $slug;

        Voiture::create(array_merge($validated, [
            'slug'        => $slug,
            'images'      => $images,
            'is_active'   => $request->boolean('is_active', true),
            'is_featured' => $request->boolean('is_featured', false),
        ]));

        return redirect()->route('admin.voitures')->with('success', '✅ Voiture ajoutée avec succès !');
    }

    public function voitureEdit(Voiture $voiture)
    {
        $categories = Category::all();
        $marques    = Marque::all();
        return view('admin.voitures.edit', compact('voiture', 'categories', 'marques'));
    }

    public function voitureUpdate(Request $request, Voiture $voiture)
    {
        $validated = $request->validate([
            'titre'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'prix_ariary'  => 'required|integer|min:0',
            'annee'        => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'kilometrage'  => 'required|integer|min:0',
            'etat'         => 'required|in:neuf,occasion',
            'couleur'      => 'nullable|string|max:50',
            'carburant'    => 'required|in:essence,diesel,electrique,hybride',
            'transmission' => 'required|in:manuelle,automatique',
            'places'       => 'required|integer|min:1|max:20',
            'puissance_cv' => 'nullable|integer',
            'category_id'  => 'required|exists:categories,id',
            'marque_id'    => 'required|exists:marques,id',
            'images.*'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $images = $voiture->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('voitures', 'public');
                $images[] = $path;
            }
        }

        $voiture->update(array_merge($validated, [
            'images'      => $images,
            'is_active'   => $request->boolean('is_active', true),
            'is_featured' => $request->boolean('is_featured', false),
        ]));

        return redirect()->route('admin.voitures')->with('success', '✅ Voiture mise à jour !');
    }

    public function voitureDestroy(Voiture $voiture)
    {
        $voiture->delete();
        return redirect()->route('admin.voitures')->with('success', '🗑️ Voiture supprimée.');
    }

    // ── Commandes ────────────────────────────────────────────
    public function commandes()
    {
        $commandes = Order::with('items')->latest()->paginate(20);
        return view('admin.commandes.index', compact('commandes'));
    }

    public function commandeShow(Order $order)
    {
        $order->load('items.voiture');
        return view('admin.commandes.show', compact('order'));
    }

    public function commandeUpdateStatut(Request $request, Order $order)
    {
        $request->validate(['statut' => 'required|in:en_attente,confirme,en_cours,livre,annule']);
        $order->update(['statut' => $request->statut]);
        return redirect()->back()->with('success', 'Statut mis à jour.');
    }

    // ── Catégories ───────────────────────────────────────────
    public function categories()
    {
        $categories = Category::withCount('voitures')->get();
        return view('admin.categories', compact('categories'));
    }

    public function categoryStore(Request $request)
    {
        $request->validate(['nom' => 'required|string|max:100', 'icone' => 'nullable|string|max:10']);
        Category::create(['nom' => $request->nom, 'icone' => $request->icone, 'slug' => Str::slug($request->nom)]);
        return redirect()->back()->with('success', 'Catégorie ajoutée.');
    }

    // ── Marques ──────────────────────────────────────────────
    public function marques()
    {
        $marques = Marque::withCount('voitures')->get();
        return view('admin.marques', compact('marques'));
    }

    public function marqueStore(Request $request)
    {
        $request->validate(['nom' => 'required|string|max:100', 'pays_origine' => 'nullable|string|max:100']);
        Marque::create(['nom' => $request->nom, 'slug' => Str::slug($request->nom), 'pays_origine' => $request->pays_origine]);
        return redirect()->back()->with('success', 'Marque ajoutée.');
    }
}
