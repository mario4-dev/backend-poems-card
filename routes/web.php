<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PoemController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth'])->name('dashboard');

// Rutas web para Inertia.js - Gestión de poemas
Route::middleware(['auth'])->group(function () {
    Route::get('poems', [PoemController::class, 'index'])->name('poems.index');
    Route::get('poems/create', [PoemController::class, 'create'])->name('poems.create');
    Route::post('poems', [PoemController::class, 'store'])->name('poems.store');
    Route::get('poems/{poem}', [PoemController::class, 'show'])->name('poems.show');
    Route::get('poems/{poem}/edit', [PoemController::class, 'edit'])->name('poems.edit');
    Route::put('poems/{poem}', [PoemController::class, 'update'])->name('poems.update');
    Route::delete('poems/{poem}', [PoemController::class, 'destroy'])->name('poems.destroy');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
