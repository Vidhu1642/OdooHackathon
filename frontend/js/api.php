<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TripController;
use App\Http\Controllers\Api\NoteController;

// Public Routes
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/itineraries/share/{token}', [ItineraryController::class, 'shared']); // Public token view

// Protected Routes (Requires Authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/status', [AuthController::class, 'status']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    
    // This single line replaces backend/trips.php ?action=create, list, get, update, delete
    Route::apiResource('trips', TripController::class);
    
    // Continue setting up your other resources:
    Route::apiResource('notes', NoteController::class);
    // Route::apiResource('budgets', BudgetController::class);
});