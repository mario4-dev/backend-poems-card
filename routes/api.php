<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PoemController;
use App\Http\Middleware\Cors;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas públicas para poemas con middleware CORS
Route::middleware([Cors::class])->group(function () {
    Route::apiResource('poems', PoemController::class);
});
