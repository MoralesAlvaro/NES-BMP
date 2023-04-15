<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// CONTROLLERS
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;


Route::get('/', function () {
    return redirect('login');
});


// ONLY DEFAULT
Route::middleware('auth', 'verified')->group(function () {
    // Ruteo para el dashboard.
    Route::get('/dashboard', function () { return Inertia::render('Dashboard'); })->name('dashboard');
    // Ruteo para las ventas.
    Route::get('/sales', function () { return Inertia::render('Sales'); })->name('sales');
    // Ruteo para el inventario.
    Route::get('/inventory', function () { return Inertia::render('Inventory'); })->name('inventory');
    // Ruteo para los reportes.
    Route::get('/report', function () { return Inertia::render('Report'); })->name('report');
    // Ruteo para los roles y usuarios.
    Route::get('/users', function () { return Inertia::render('Users'); })->name('users');
    // Ruteo para la sección de ayuda.
    Route::get('/help', function () { return Inertia::render('Help'); })->name('help');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ONLY VIEWS RESPONSE
Route::middleware('auth')->group(function () {
    Route::get('/role/list', [RolePermissionController::class, 'index'])->name('roleList');
    Route::get('/user/list', [UserController::class, 'index'])->name('user.list');
    Route::get('/category/list', [CategoryController::class, 'index'])->name('category.list');
    Route::get('/product/list', [ProductController::class, 'index'])->name('product.list');
});


// ONLY RESPONSE
Route::middleware('auth')->group(function () {
    Route::post('/send/invitation', [UserController::class, 'send_invitation'])->name('invite.user');
    Route::post('/changeRole', [UserController::class, 'change_role'])->name('change.role');
    Route::get('/deleteUser/{user}', [UserController::class, 'destroy'])->name('delete.user');
    // Products
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    // Category
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::post('/category/update', [CategoryController::class, 'update'])->name('category.update');
    Route::get('/category/destroy', [CategoryController::class, 'destroy'])->name('category.destroy');
});

require __DIR__.'/auth.php';
