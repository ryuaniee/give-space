<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\PaymentSettingController;
use App\Http\Controllers\AdminTransactionController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminDashboardController;

use App\Http\Controllers\DonationController;
use App\Http\Controllers\UserCampaignController;
use App\Http\Controllers\UserDashboardController;

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('home');
    })->name('home');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('categories', CategoryController::class);
    Route::resource('campaigns', CampaignController::class);

    Route::get('/payment-settings', [PaymentSettingController::class, 'edit'])
        ->name('payment-settings.edit');

    Route::put('/payment-settings', [PaymentSettingController::class, 'update'])
        ->name('payment-settings.update');

    Route::get('/transactions', [AdminTransactionController::class, 'index'])
        ->name('transactions.index');

    Route::get('/transactions/{transaction}', [AdminTransactionController::class, 'show'])
        ->name('transactions.show');

    Route::get('/transactions/{transaction}/pdf', [AdminTransactionController::class, 'pdf'])
        ->name('transactions.pdf');

    Route::post('/transactions/{transaction}/verify', [AdminTransactionController::class, 'verify'])
        ->name('transactions.verify');

    Route::post('/transactions/{transaction}/reject', [AdminTransactionController::class, 'reject'])
        ->name('transactions.reject');

    Route::get('/users', [AdminUserController::class, 'index'])
        ->name('users.index');

    Route::get('/users/{user}', [AdminUserController::class, 'show'])
        ->name('users.show');
});

Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/campaigns', [UserCampaignController::class, 'index'])
            ->name('campaigns.index');

        Route::get('/campaigns/{campaign}', [UserCampaignController::class, 'show'])
            ->name('campaigns.show');

        Route::get('/campaigns/{campaign}/donate', [DonationController::class, 'create'])
            ->name('donations.create');

        Route::post('/campaigns/{campaign}/donate', [DonationController::class, 'store'])
            ->name('donations.store');

        Route::get('/donations/{transaction}/thank-you', [DonationController::class, 'thankYou'])
            ->name('donations.thank-you');

        Route::get('/transactions', [DonationController::class, 'index'])
            ->name('transactions.index');

        Route::get('/transactions/{transaction}/pdf', [DonationController::class, 'pdf'])
            ->name('transactions.pdf');

        Route::get('/transactions/{transaction}', [DonationController::class, 'show'])
            ->name('transactions.show');
    });
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');