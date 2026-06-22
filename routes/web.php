<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminTableController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SistemController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Login & Register
Route::get('/login', [AuthController::class, 'Login'])->name('login');
Route::get('/register', [AuthController::class, 'Register'])->name('register');
Route::post('/doregister', [AuthController::class, 'store'])->name('doregister');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware([App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
    Route::get('/menus/create', [MenuController::class, 'create'])->name('menus.create');
    Route::post('/menus', [MenuController::class, 'store'])->name('menus.store');
    Route::get('/menus/{menu}/edit', [MenuController::class, 'edit'])->name('menus.edit');
    Route::put('/menus/{menu}', [MenuController::class, 'update'])->name('menus.update');
    Route::delete('/menus/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy');

    Route::get('/tables', [AdminTableController::class, 'index'])->name('tables.index');
    Route::get('/tables/create', [AdminTableController::class, 'create'])->name('tables.create');
    Route::post('/tables', [AdminTableController::class, 'store'])->name('tables.store');
    Route::get('/tables/{table}/edit', [AdminTableController::class, 'edit'])->name('tables.edit');
    Route::put('/tables/{table}', [AdminTableController::class, 'update'])->name('tables.update');
    Route::delete('/tables/{table}', [AdminTableController::class, 'destroy'])->name('tables.destroy');


    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [AdminOrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [AdminOrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/receipt', [AdminOrderController::class, 'receipt'])->name('orders.receipt');
    Route::post('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
    Route::post('/orders/{order}/pay', [AdminOrderController::class, 'pay'])->name('orders.pay');
});

Route::get('/order/table/{tableNumber}', [OrderController::class, 'showTableOrder'])->name('orders.table');
Route::post('/order/table/{tableNumber}/confirm', [OrderController::class, 'confirmTableOrder'])->name('orders.confirm');
Route::post('/order/table/{tableNumber}/submit', [OrderController::class, 'submitTableOrder'])->name('orders.submit');
Route::get('/order/{orderId}/tracking', [OrderController::class, 'trackOrder'])->name('orders.tracking');
Route::get('/order/{orderId}/payment', [OrderController::class, 'paymentPage'])->name('orders.payment');
Route::post('/order/{orderId}/payment', [OrderController::class, 'processPayment'])->name('orders.process-payment');
Route::get('/order/table/{tableNumber}/thankyou', [OrderController::class, 'thankyou'])->name('orders.thankyou');

Route::get('/master', [SistemController::class, 'index']);
Route::get('/form', [SistemController::class, 'form']);
Route::get('/home', [SistemController::class, 'home']);

