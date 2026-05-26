<?php

use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\PackageEventController;
use App\Http\Controllers\PublicTrackingController;
use App\Http\Controllers\Auth\LoginController; // Import bien présent

// --- ROUTES PUBLIQUES (Accessibles par les clients) ---
Route::get('/', [PublicTrackingController::class, 'index'])->name('home');
Route::get('/track', [PublicTrackingController::class, 'track'])->name('tracking.track');


// --- ROUTES D'AUTHENTIFICATION (À ajouter pour que l'admin puisse se connecter) ---
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// --- ROUTES SÉCURISÉES ADMIN (Uniquement pour l'administration) ---
// Note : Si tu as une erreur sur 'admin', remplace-le par \App\Http\Middleware\AdminMiddleware::class
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Routes pour la gestion des colis (index, create, store, edit, update, destroy)
    Route::resource('packages', PackageController::class);
    
    // Route spécifique pour ajouter un événement à la timeline d'un colis
    Route::post('packages/{package}/events', [PackageEventController::class, 'store'])
        ->name('packages.events.store');
        
    // Routes si tu gères l'update/delete des événements de manière isolée
    Route::put('events/{event}', [PackageEventController::class, 'update'])->name('events.update');
    Route::delete('events/{event}', [PackageEventController::class, 'destroy'])->name('events.destroy');
});