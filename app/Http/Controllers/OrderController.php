<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private function getCart(): ?Cart
    {
        if (auth()->check()) {
            return Cart::with('items.voiture')->where('user_id', auth()->id())->first();
        }
        return Cart::with('items.voiture')->where('session_id', session()->getId())->first();
    }

    public function create()
    {
        $cart = $this->getCart();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        return view('orders.create', compact('cart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_client' => 'required|string|max:255',
            'telephone'  => 'required|string|max:20',
            'adresse'    => 'required|string',
            'email'      => 'nullable|email|max:255',
            'notes'      => 'nullable|string',
        ]);

        $cart = $this->getCart();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        // Calcul du total
        $total = $cart->items->sum(fn($item) => $item->voiture->prix_ariary * $item->quantite);

        // Création de la commande
        $order = Order::create([
            'user_id'     => auth()->id(),
            'nom_client'  => $request->nom_client,
            'telephone'   => $request->telephone,
            'adresse'     => $request->adresse,
            'email'       => $request->email,
            'total_ariary'=> $total,
            'statut'      => 'en_attente',
            'notes'       => $request->notes,
        ]);

        // Copier les items du panier en items de commande
        foreach ($cart->items as $item) {
            OrderItem::create([
                'order_id'      => $order->id,
                'voiture_id'    => $item->voiture_id,
                'titre_voiture' => $item->voiture->titre,
                'prix_ariary'   => $item->voiture->prix_ariary,
                'quantite'      => $item->quantite,
            ]);
        }

        // Vider le panier
        $cart->items()->delete();

        return redirect()->route('orders.confirmation', $order->reference)
            ->with('success', 'Votre commande a été passée avec succès !');
    }

    public function confirmation(string $reference)
    {
        $order = Order::with('items.voiture')->where('reference', $reference)->firstOrFail();
        return view('orders.confirmation', compact('order'));
    }

    public function monHistorique()
    {
        $orders = Order::with('items')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('orders.historique', compact('orders'));
    }
}
