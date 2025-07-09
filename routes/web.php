<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\DoctorPrescriptionTransactionController;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::post('/products/import', [ProductController::class, 'import'])->name('products.import');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');



Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transactions.show');
Route::get('/transactions/{id}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
Route::put('/transactions/{id}', [TransactionController::class, 'update'])->name('transactions.update');
Route::delete('/transactions/{id}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

Route::get('/transactions/invoice/{batchId}', [TransactionController::class, 'invoice'])
    ->name('transactions.invoice');
Route::get('/transactions/product-search', [TransactionController::class, 'productSearch'])->name('transactions.productSearch');
Route::get('/transactions/{transaction}/invoice', [TransactionController::class, 'invoice'])->name('transactions.invoice');

Route::middleware(['auth'])->group(function () {
    Route::resource('resep-transactions', DoctorPrescriptionTransactionController::class);
});


Route::get('/report', [ReportController::class, 'index'])->name('report.index');
Route::get('/report/filter', [ReportController::class, 'filter'])->name('report.filter');
Route::get('/report/print/{start_date}/{end_date}', [ReportController::class, 'print'])->name('report.print');

// Rute untuk Laporan Laba Rugi
Route::get('/profit-loss', [ReportController::class, 'showProfitLoss'])->name('profit-loss.show');
Route::get('/profit-loss/filter', [ReportController::class, 'filterProfitLoss'])->name('profit-loss.filter');
Route::get('/profit-loss/print/{startDate}/{endDate}', [ReportController::class, 'printProfitLoss'])->name('profit-loss.print');

// Rute untuk Laporan Penjualan per Obat
Route::get('/sales-by-product', [ReportController::class, 'showSalesByProduct'])->name('sales-by-product.show');
Route::get('/sales-by-product/filter', [ReportController::class, 'filterSalesByProduct'])->name('sales-by-product.filter');
Route::get('/sales-by-product/print/{startDate}/{endDate}', [ReportController::class, 'printSalesByProduct'])->name('sales-by-product.print');

Route::get('/about', function () {
    return view('about.index');
})->name('about');

Route::resource('suppliers', SupplierController::class);


// Authentication Routes
use App\Http\Controllers\Auth\LoginController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::middleware(['auth', 'role:admin,kasir'])->group(function () {
//     Route::get('/users', [UserController::class, 'index'])->name('users.index');
//     Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
//     Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
//     Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::middleware(['auth', 'role:admin,kasir'])->group(function () {
    Route::resource('users', UserController::class);

    Route::resource('prescriptions', PrescriptionController::class)->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
});
