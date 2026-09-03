<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'user')
            ->withCount([
                'transactions',
                'transactions as verified_transactions_count' => function ($query) {
                    $query->where('status', 'verified');
                },
            ]);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        abort_if($user->role !== 'user', 404);

        $transactions = $user->transactions()
            ->with('campaign')
            ->latest()
            ->paginate(10);

        $totalDonation = $user->transactions()
            ->where('status', 'verified')
            ->sum('amount');

        return view('admin.users.show', compact('user', 'transactions', 'totalDonation'));
    }
}