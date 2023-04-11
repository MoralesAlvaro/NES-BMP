<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// CONTROLLERS
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;


Route::get('/', function () {
    return redirect('login');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
});


// ONLY RESPONSE
Route::middleware('auth')->group(function () {
    Route::post('/send/invitation', [UserController::class, 'send_invitation'])->name('invite.user');
    Route::post('/changeRole', [UserController::class, 'change_role'])->name('change.role');
    Route::get('/deleteUser/{user}', [UserController::class, 'destroy'])->name('delete.user');
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
});

require __DIR__.'/auth.php';
