<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
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



Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/payments', [PaymentController::class, 'index'])->middleware(['auth', 'verified'])->name('payments.index');
Route::get('/payments/create', [PaymentController::class, 'create'])->middleware(['auth', 'verified'])->name('payments.create');
Route::post('/payments/create', [PaymentController::class, 'store'])->middleware(['auth', 'verified'])->name('payments.store');
Route::post('/payments/import', [PaymentController::class, 'import'])->middleware(['auth', 'verified'])->name('payments.import');
//Route::post('/payments/store', [PaymentController::class, 'store'])->middleware(['auth', 'verified'])->name('payments.store');
Route::get('/clients', [ClientController::class, 'index'])->middleware(['auth', 'verified'])->name('clients.index');

require __DIR__ . '/auth.php';
