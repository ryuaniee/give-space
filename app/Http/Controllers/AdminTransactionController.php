<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'campaign']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($query) use ($search) {
                $query->where('transaction_code', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('campaign', function ($query) use ($search) {
                        $query->where('title', 'like', "%{$search}%");
                    });
            });
        }

        $transactions = $query->latest()->paginate(10)->withQueryString();

        return view('admin.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['user', 'campaign']);

        return view('admin.transactions.show', compact('transaction'));
    }

    public function verify(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi ini sudah diproses.');
        }

        $transaction->update([
            'status' => 'verified',
            'verified_at' => now(),
            'rejection_reason' => null,
        ]);

        return redirect()
            ->route('admin.transactions.show', $transaction)
            ->with('success', 'Transaksi berhasil diverifikasi.');
    }

    public function reject(Request $request, Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaksi ini sudah diproses.');
        }

        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:1000'],
        ], [
            'rejection_reason.required' => 'Alasan penolakan wajib diisi.',
        ]);

        $transaction->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
            'verified_at' => null,
        ]);

        return redirect()
            ->route('admin.transactions.show', $transaction)
            ->with('success', 'Transaksi berhasil ditolak.');
    }

    public function pdf(Transaction $transaction)
    {
        $transaction->load(['user', 'campaign']);

        $pdf = Pdf::loadView('user.transactions.pdf', compact('transaction'));

        return $pdf->download($transaction->transaction_code . '.pdf');
    }
}