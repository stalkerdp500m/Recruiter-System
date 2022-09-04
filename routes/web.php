<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Import\ImportPaymentController;
use App\Http\Controllers\Import\IndexController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReclamationController;
use App\Http\Controllers\RecruiterController;
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


Route::get('/control/users', [UserController::class, 'index'])->middleware(['auth', 'verified', 'admin'])->name('control.users.index');
Route::get('/control/users/create', [UserController::class, 'create'])->middleware(['auth', 'verified', 'admin'])->name('control.users.create');
Route::post('/control/users/check-email', [UserController::class, 'checkEmail'])->middleware(['auth', 'verified', 'admin'])->name('control.users.checkEmail');
Route::post('/control/users/store', [UserController::class, 'store'])->middleware(['auth', 'verified', 'admin'])->name('control.users.store');
Route::put('/control/users/{user}', [UserController::class, 'update'])->middleware(['auth', 'verified', 'admin'])->name('control.users.update');

Route::get('/control/recruiters', [RecruiterController::class, 'index'])->middleware(['auth', 'verified', 'admin'])->name('control.recruiters.index');
Route::put('/control/recruiters/{recruiter}', [RecruiterController::class, 'update'])->middleware(['auth', 'verified', 'admin'])->name('control.recruiters.update');
Route::post('/control/recruiters/check-email', [RecruiterController::class, 'checkEmail'])->middleware(['auth', 'verified', 'admin'])->name('control.recruiters.checkEmail');
Route::post('/control/recruiters/store', [RecruiterController::class, 'store'])->middleware(['auth', 'verified', 'admin'])->name('control.recruiters.store');

Route::get('/control/teams', [TeamController::class, 'index'])->middleware(['auth', 'verified', 'admin'])->name('control.teams.index');
Route::put('/control/teams/{team}', [TeamController::class, 'update'])->middleware(['auth', 'verified', 'admin'])->name('control.teams.update');
Route::post('/control/teams/store', [TeamController::class, 'store'])->middleware(['auth', 'verified', 'admin'])->name('control.teams.store');


// Route::get('/demo-mail', function () {
//     return (new MailMessage)
//         ->subject(Lang::get('Уведомление о сбросе пароля'))
//         ->line(Lang::get('Вы получили это письмо, потому что мы получили запрос на сброс пароля для вашей учетной записи.'))
//         ->action(Lang::get('сбросить пароль'), "url")
//         ->line(Lang::get('срок действия ссылки для сброса пароля истекает через :count минут.', ['count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')]))
//         ->line(Lang::get('Если вы не запрашивали сброс пароля, никаких дальнейших действий не требуется.'));
// });




require __DIR__ . '/auth.php';
