<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PoemController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas protegidas para la gestión de poemas del usuario
Route::apiResource('poems', PoemController::class)->middleware('auth:sanctum');

// Ruta pública para estadísticas globales
Route::get('poems/stats', [PoemController::class, 'stats']);
