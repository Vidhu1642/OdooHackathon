<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Authentication Routes ---
// Mapped to the combined auth.blade.php view
Route::view('/login', 'auth')->name('login');
Route::view('/register', 'auth')->name('register');
Route::post('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');

// --- Protected Routes ---
Route::middleware(['auth'])->group(function () {

    // Profile Routes (Using ProfileController)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Routes (Using AdminController)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.destroy');
    });

    // Application Views
    // Note: These use Route::get with closures to pass empty arrays/dummy data 
    // since their specific controllers weren't provided, preventing undefined variable errors in Blade.
    Route::get('/dashboard', function () { return view('dashboard'); });
    Route::get('/create-trip', function () { return view('create-trip'); });
    Route::get('/my-trips', function () { return view('my-trip', ['trips' => []]); });
    Route::get('/itinerary', function () { return view('itinerary', ['cities' => [], 'totalActivities' => 0, 'totalDays' => 0, 'totalBudget' => 0]); });
    Route::get('/itinerary-view', function () { return view('itinerary-view', ['trip' => ['image' => '', 'title' => '', 'description' => '', 'days' => 0, 'cities' => 0, 'activities' => 0, 'budget' => 0, 'map_image' => ''], 'timeline' => []]); });
    Route::get('/activity-search', function () { return view('activity-search', ['activities' => []]); });
    
    // Static views without required data
    Route::view('/search', 'search');
    Route::view('/budget', 'budget');
    Route::view('/packing', 'packing');
});