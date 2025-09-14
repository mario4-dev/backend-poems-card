<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas para administración de poemas
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/poems', function () {
        return Inertia::render('Poems/Index');
    })->name('poems.index');
    
    Route::get('/poems/create', function () {
        return Inertia::render('Poems/Create');
    })->name('poems.create');
    
    Route::get('/poems/{id}/edit', function ($id) {
        return Inertia::render('Poems/Edit', [
            'id' => $id,
        ]);
    })->name('poems.edit');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
