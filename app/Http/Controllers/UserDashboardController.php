<?php

namespace App\Http\Controllers;

use App\Models\Campaign;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalDonation = $user->transactions()
            ->where('status', 'verified')
            ->sum('amount');

        $totalTransactions = $user->transactions()->count();

        $latestDonation = $user->transactions()
            ->with('campaign')
            ->latest()
            ->first();

        $campaigns = Campaign::with('category')
            ->withSum([
                'transactions as collected_amount' => function ($query) {
                    $query->where('status', 'verified');
                }
            ], 'amount')
            ->where('status', 'active')
            ->latest()
            ->limit(6)
            ->get();

        $recentTransactions = $user->transactions()
            ->with('campaign')
            ->latest()
            ->limit(5)
            ->get();

        return view('user.dashboard', compact(
            'totalDonation',
            'totalTransactions',
            'latestDonation',
            'campaigns',
            'recentTransactions'
        ));
    }
}