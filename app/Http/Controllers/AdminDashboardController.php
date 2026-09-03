<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Transaction;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalDonation = Transaction::where('status', 'verified')->sum('amount');
        $totalTransactions = Transaction::count();
        $activeCampaigns = Campaign::where('status', 'active')->count();
        $totalDonors = User::where('role', 'user')->count();

        $recentTransactions = Transaction::with(['user', 'campaign'])
            ->latest()
            ->limit(5)
            ->get();

        $activeCampaignList = Campaign::with('category')
            ->where('status', 'active')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalDonation',
            'totalTransactions',
            'activeCampaigns',
            'totalDonors',
            'recentTransactions',
            'activeCampaignList'
        ));
    }
}