<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Ruteo para el dashboard.
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Ruteo para las ventas.
Route::get('/sales', function () {
    return Inertia::render('Sales');
})->middleware(['auth', 'verified'])->name('sales');

// Ruteo para el inventario.
Route::get('/inventory', function () {
    return Inertia::render('Inventory');
})->middleware(['auth', 'verified'])->name('inventory');

// Ruteo para los reportes.
Route::get('/report', function () {
    return Inertia::render('Report');
})->middleware(['auth', 'verified'])->name('report');

// Ruteo para los roles y usuarios.
Route::get('/users', function () {
    return Inertia::render('Users');
})->middleware(['auth', 'verified'])->name('users');

// Ruteo para la sección de ayuda.
Route::get('/help', function () {
    return Inertia::render('Help');
})->middleware(['auth', 'verified'])->name('help');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
