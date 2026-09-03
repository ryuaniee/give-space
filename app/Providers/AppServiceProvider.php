<?php

namespace App\Providers;

use App\Models\Transaction;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('components.dashboard.sidebar', function ($view) {
            $pendingTransactions = 0;

            if (auth()->check() && auth()->user()->role === 'admin') {
                $pendingTransactions = Transaction::where('status', 'pending')->count();
            }

            $view->with('pendingTransactions', $pendingTransactions);
        });
    }
}