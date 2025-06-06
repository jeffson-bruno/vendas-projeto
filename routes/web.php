<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Models\Sale;
use App\Models\Product;

// Autenticação
require __DIR__.'/auth.php';

// Página inicial (Dashboard)
//Route::get('/', function () {
    //return view('dashboard');
//})->middleware(['auth'])->name('dashboard');
Route::get('/', function () {
    $totalVendas = Sale::count();
    $totalProdutos = Product::count();
    $faturamento = Sale::sum('total');

    return view('dashboard', compact('totalVendas', 'totalProdutos', 'faturamento'));
})->middleware(['auth'])->name('dashboard');

// Protegendo as rotas com login
Route::middleware(['auth'])->group(function () {

    // Clientes
    Route::resource('clients', ClientController::class);

    // Produtos
    Route::resource('products', ProductController::class);

    // Formas de pagamento
    Route::resource('payment-methods', PaymentMethodController::class);

    // Vendas
    Route::resource('sales', SaleController::class);

    // PDF da venda
    Route::get('sales/{id}/pdf', [SaleController::class, 'generatePdf'])->name('sales.pdf');

    Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
});

