<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Import\ImportPaymentController;
use App\Http\Controllers\Import\IndexController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReclamationController;
use App\Http\Controllers\RecruiterController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
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


Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile',  [ProfileController::class, 'index'])->name('profile');

    Route::get('/profile/create-token',  [ProfileController::class, 'createToken'])->middleware('admin')->name('create-token');
    Route::get('/imports/salary',  [SalaryController::class, 'index'])->middleware('admin')->name('imports.salary.index');

    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');



    Route::group(['as' => 'payments.', 'prefix' => 'payments', 'controller' => PaymentController::class], function () {
        Route::get('/', 'index')->name('index');
    });
    Route::group(['as' => 'notifications.', 'prefix' => 'notifications', 'controller' => NotificationController::class], function () {
        Route::get('/', 'index')->name('index');
        Route::put('/read/{id}', 'read')->name('read');
    });

    Route::group(['as' => 'imports.payments.', 'prefix' => 'imports', 'middleware' => ['admin'], 'controller' => ImportPaymentController::class], function () {
        Route::get('/payments',  'index')->name('index');
        Route::post('/payments',  'create')->name('create');
        Route::post('/payments/store/', 'store')->name('store');
    });

    Route::group(['as' => 'reclamations.', 'prefix' => 'reclamations', 'controller' => ReclamationController::class], function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{reclamation}/edit', 'edit')->name('edit')->middleware(['can:update,reclamation']);
        Route::put('/{reclamation}', 'update')->name('update')->middleware(['can:update,reclamation']);
        Route::post('/', 'store')->name('store');
        Route::delete('/{reclamation}', 'destroy')->name('destroy')->middleware(['can:delete,reclamation']);
        Route::put('/{reclamation}/restore', 'restore')->name('restore')->middleware(['can:restore,reclamation']);
    });

    Route::group(['as' => 'control.', 'middleware' => ['admin']], function () {
        Route::group(['as' => 'users.', 'prefix' => 'users', 'controller' => UserController::class], function () {
            Route::get('/', 'index')->name('index');
            Route::put('/{user}', 'update')->name('update');
            Route::post('/check-email',  'checkEmail')->name('checkEmail');
            Route::post('/store',  'store')->name('store');
        });
        Route::group(['as' => 'recruiters.', 'prefix' => 'recruiters', 'controller' => RecruiterController::class], function () {
            Route::get('/', 'index')->name('index');
            Route::put('/{recruiter}', 'update')->name('update');
            Route::post('/check-email',  'checkEmail')->name('checkEmail');
            Route::post('/store',  'store')->name('store');
        });
        Route::group(['as' => 'teams.', 'prefix' => 'teams', 'controller' => TeamController::class], function () {
            Route::get('/', 'index')->name('index');
            Route::put('/{team}', 'update')->name('update');
            Route::post('/store',  'store')->name('store');
        });
    });
});



require __DIR__ . '/auth.php';
