<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController; // Make sure this is imported

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home page (public landing page)
Route::get('/', [HomeController::class, 'index'])->name('home');

// ------------------------------------------------------------------
// CHANGED: I removed ->middleware(['auth', 'verified'])
// and replaced it with just ->middleware('auth')
// This means you only need to be logged in, but not verified.
// ------------------------------------------------------------------
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth') 
    ->name('dashboard');


// Authenticated user routes
Route::middleware('auth')->group(function () {
    // Products CRUD routes (only accessible when logged in)
    Route::resource('products', ProductController::class);

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/run-migrations-abc123xyz', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        return 'Migrations executed successfully!';
    } catch (Exception $e) {
        return 'Migration failed: ' . $e->getMessage();
    }
});

require __DIR__ . '/auth.php';

