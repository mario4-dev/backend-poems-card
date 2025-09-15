<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PoemController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// RUTAS PÚBLICAS (deben ir ANTES de las rutas con parámetros)
// Ruta pública para estadísticas globales
Route::get('poems/stats', [PoemController::class, 'stats']);

// Ruta pública para obtener poemas (para el frontend React)
Route::get('poems/public', [PoemController::class, 'publicPoems']);

// Rutas protegidas para la gestión de poemas del usuario
Route::apiResource('poems', PoemController::class)->middleware('auth:sanctum');
