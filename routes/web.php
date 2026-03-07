<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VoitureController;
use Illuminate\Support\Facades\Route;

// ── Pages publiques ──────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

// Voitures
Route::prefix('voitures')->name('voitures.')->group(function () {
    Route::get('/', [VoitureController::class, 'index'])->name('index');
    Route::get('/{slug}', [VoitureController::class, 'show'])->name('show');
});

// Panier
Route::prefix('panier')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/ajouter', [CartController::class, 'ajouter'])->name('ajouter');
    Route::post('/retirer', [CartController::class, 'retirer'])->name('retirer');
    Route::post('/vider', [CartController::class, 'vider'])->name('vider');
});

// Commandes
Route::prefix('commande')->name('orders.')->group(function () {
    Route::get('/nouvelle', [OrderController::class, 'create'])->name('create');
    Route::post('/nouvelle', [OrderController::class, 'store'])->name('store');
    Route::get('/confirmation/{reference}', [OrderController::class, 'confirmation'])->name('confirmation');
});

Route::middleware('auth')->group(function () {
    Route::get('/mes-commandes', [OrderController::class, 'monHistorique'])->name('orders.historique');

    // Profile (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ── Admin ────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Voitures
    Route::get('/voitures', [AdminController::class, 'voitures'])->name('voitures');
    Route::get('/voitures/creer', [AdminController::class, 'voitureCreate'])->name('voitures.create');
    Route::post('/voitures', [AdminController::class, 'voitureStore'])->name('voitures.store');
    Route::get('/voitures/{voiture}/modifier', [AdminController::class, 'voitureEdit'])->name('voitures.edit');
    Route::put('/voitures/{voiture}', [AdminController::class, 'voitureUpdate'])->name('voitures.update');
    Route::delete('/voitures/{voiture}', [AdminController::class, 'voitureDestroy'])->name('voitures.destroy');

    // Commandes
    Route::get('/commandes', [AdminController::class, 'commandes'])->name('commandes');
    Route::get('/commandes/{order}', [AdminController::class, 'commandeShow'])->name('commandes.show');
    Route::patch('/commandes/{order}/statut', [AdminController::class, 'commandeUpdateStatut'])->name('commandes.statut');

    // Catégories
    Route::get('/categories', [AdminController::class, 'categories'])->name('categories');
    Route::post('/categories', [AdminController::class, 'categoryStore'])->name('categories.store');

    // Marques
    Route::get('/marques', [AdminController::class, 'marques'])->name('marques');
    Route::post('/marques', [AdminController::class, 'marqueStore'])->name('marques.store');
});

require __DIR__ . '/auth.php';
