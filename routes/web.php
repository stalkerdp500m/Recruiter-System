<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Import\ImportPaymentController;
use App\Http\Controllers\Import\IndexController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReclamationController;
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

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });



Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/profile',  [ProfileController::class, 'index'])->middleware(['auth', 'verified', 'admin'])->name('profile');
Route::get('/profile/create-token',  [ProfileController::class, 'createToken'])->middleware(['auth', 'verified', 'admin'])->name('create-token');

Route::get('/payments', [PaymentController::class, 'index'])->middleware(['auth', 'verified'])->name('payments.index');
Route::get('/payments/create', [PaymentController::class, 'create'])->middleware(['auth', 'verified'])->name('payments.create');
Route::post('/payments/create', [PaymentController::class, 'store'])->middleware(['auth', 'verified'])->name('payments.store');
Route::post('/payments/import', [PaymentController::class, 'import'])->middleware(['auth', 'verified'])->name('payments.import');
Route::get('/clients', [ClientController::class, 'index'])->middleware(['auth', 'verified'])->name('clients.index');
//Route::post('/clients', [ClientController::class, 'search'])->middleware(['auth', 'verified'])->name('clients.search');

Route::get('/reclamations', [ReclamationController::class, 'index'])->middleware(['auth', 'verified'])->name('reclamations.index');
Route::get('/reclamations/{reclamation}/edit', [ReclamationController::class, 'edit'])->middleware(['auth', 'verified'])->name('reclamations.edit');
Route::put('/reclamations/{reclamation}', [ReclamationController::class, 'update'])->middleware(['auth', 'verified'])->name('reclamations.update');
Route::post('/reclamations', [ReclamationController::class, 'store'])->middleware(['auth', 'verified'])->name('reclamations.store');
Route::delete('/reclamations/{reclamation}', [ReclamationController::class, 'destroy'])->middleware(['auth', 'verified'])->name('reclamations.destroy');
Route::put('reclamations/{reclamation}/restore', [ReclamationController::class, 'restore'])->middleware(['auth', 'verified'])->name('reclamations.restore');

Route::get('/imports/payments/', [ImportPaymentController::class, 'index'])->middleware(['auth', 'verified', 'admin'])->name('imports.payments.index');
Route::post('/imports/payments/', [ImportPaymentController::class, 'create'])->middleware(['auth', 'verified', 'admin'])->name('imports.payments.create');
Route::post('/imports/payments/store/', [ImportPaymentController::class, 'store'])->middleware(['auth', 'verified', 'admin'])->name('imports.payments.store');

require __DIR__ . '/auth.php';
