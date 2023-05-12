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
use App\Http\Controllers\RawMaterialController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\DetailSaleController;
use App\Http\Controllers\GeneralExpensesController;


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
    Route::get('/rawMaterial/list', [RawMaterialController::class, 'index'])->name('rawMaterial.list');
    Route::get('/stock/list', [StockController::class, 'index'])->name('stock.list');
    Route::get('/sale/list', [SaleController::class, 'index'])->name('sale.list');
    Route::get('/expense/list', [GeneralExpensesController::class, 'index'])->name('expense.list');
});


// ONLY RESPONSE
Route::middleware('auth')->group(function () {
    Route::post('/send/invitation', [UserController::class, 'send_invitation'])->name('invite.user');
    Route::post('/changeRole', [UserController::class, 'change_role'])->name('change.role');
    Route::get('/deleteUser/{user}', [UserController::class, 'destroy'])->name('delete.user');

    // Products
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    Route::post('/product/update', [ProductController::class, 'update'])->name('product.update');
    Route::get('/product/destroy', [ProductController::class, 'destroy'])->name('product.destroy');

    // Category
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::post('/category/update', [CategoryController::class, 'update'])->name('category.update');
    Route::get('/category/destroy', [CategoryController::class, 'destroy'])->name('category.destroy');

    // rawMaterial
    Route::post('/rawMaterial/store', [RawMaterialController::class, 'store'])->name('rawMaterial.store');
    Route::post('/rawMaterial/update', [RawMaterialController::class, 'update'])->name('rawMaterial.update');
    Route::get('/rawMaterial/destroy', [RawMaterialController::class, 'destroy'])->name('rawMaterial.destroy');

    // Sale
    Route::post('/sale/store', [SaleController::class, 'store'])->name('sale.store');
    Route::post('/sale/update', [SaleController::class, 'update'])->name('sale.update');
    Route::get('/sale/destroy', [SaleController::class, 'destroy'])->name('sale.destroy');

    // Detail sale
    Route::get('/detailSale/destroy', [DetailSaleController::class, 'destroy'])->name('detailSale.destroy');

    // General expenses
    Route::post('/expense/store', [GeneralExpensesController::class, 'store'])->name('expense.store');
    Route::post('/expense/update', [GeneralExpensesController::class, 'update'])->name('expense.update');
    Route::get('/expense/destroy', [GeneralExpensesController::class, 'destroy'])->name('expense.destroy');
});

require __DIR__.'/auth.php';
