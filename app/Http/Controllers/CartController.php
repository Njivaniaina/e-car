<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Voiture;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function getOrCreateCart(): Cart
    {
        if (auth()->check()) {
            return Cart::firstOrCreate(['user_id' => auth()->id()]);
        }

        $sessionId = session()->getId();
        return Cart::firstOrCreate(['session_id' => $sessionId, 'user_id' => null]);
    }

    public function index()
    {
        $cart = $this->getOrCreateCart();
        $cart->load('items.voiture.category', 'items.voiture.marque');

        return view('cart.index', compact('cart'));
    }

    public function ajouter(Request $request)
    {
        $request->validate(['voiture_id' => 'required|exists:voitures,id']);

        $voiture = Voiture::active()->findOrFail($request->voiture_id);
        $cart    = $this->getOrCreateCart();

        $item = CartItem::where('cart_id', $cart->id)
            ->where('voiture_id', $voiture->id)
            ->first();

        if ($item) {
            $item->increment('quantite');
        } else {
            CartItem::create([
                'cart_id'    => $cart->id,
                'voiture_id' => $voiture->id,
                'quantite'   => 1,
            ]);
        }

        return redirect()->back()->with('success', '✅ ' . $voiture->titre . ' ajouté au panier !');
    }

    public function retirer(Request $request)
    {
        $request->validate(['item_id' => 'required|exists:cart_items,id']);

        $cart = $this->getOrCreateCart();
        CartItem::where('id', $request->item_id)
            ->where('cart_id', $cart->id)
            ->delete();

        return redirect()->back()->with('success', '🗑️ Article retiré du panier.');
    }

    public function vider()
    {
        $cart = $this->getOrCreateCart();
        $cart->items()->delete();

        return redirect()->back()->with('success', 'Panier vidé.');
    }

    public function nombreItems(): int
    {
        $cart = $this->getOrCreateCart();
        return $cart->items()->sum('quantite');
    }
}
