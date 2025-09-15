<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PoemController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas públicas para poemas (CORS se maneja por config/cors.php globalmente)
Route::apiResource('poems', PoemController::class);
