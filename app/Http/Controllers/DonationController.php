<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\PaymentSetting;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class DonationController extends Controller
{
    public function create(Campaign $campaign)
    {
        if ($campaign->status !== 'active') {
            abort(404);
        }

        $paymentSetting = PaymentSetting::first();

        return view('user.donations.create', compact('campaign', 'paymentSetting'));
    }

    public function store(Request $request, Campaign $campaign)
    {
        if ($campaign->status !== 'active') {
            abort(404);
        }

        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:1000'],
            'payment_method' => ['required', 'in:qris,bank_transfer'],
            'payment_proof' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'amount.required' => 'Nominal donasi wajib diisi.',
            'amount.numeric' => 'Nominal donasi harus berupa angka.',
            'amount.min' => 'Minimal donasi adalah Rp1.000.',
            'payment_method.required' => 'Metode pembayaran wajib dipilih.',
            'payment_method.in' => 'Metode pembayaran tidak valid.',
            'payment_proof.required' => 'Bukti pembayaran wajib diupload.',
            'payment_proof.image' => 'Bukti pembayaran harus berupa gambar.',
            'payment_proof.mimes' => 'Format bukti pembayaran harus JPG, JPEG, PNG, atau WEBP.',
            'payment_proof.max' => 'Ukuran bukti pembayaran maksimal 2 MB.',
        ]);

        $paymentSetting = PaymentSetting::first();

        if (!$paymentSetting) {
            return back()
                ->withInput()
                ->with('error', 'Informasi pembayaran belum tersedia.');
        }

        if ($validated['payment_method'] === 'qris' && !$paymentSetting->qris_image) {
            return back()
                ->withInput()
                ->with('error', 'Pembayaran QRIS belum tersedia.');
        }

        if ($validated['payment_method'] === 'bank_transfer' && (!$paymentSetting->bank_name || !$paymentSetting->account_number || !$paymentSetting->account_name)) {
            return back()
                ->withInput()
                ->with('error', 'Informasi rekening belum tersedia.');
        }

        $paymentProof = $request->file('payment_proof')->store('payment-proofs', 'public');

        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'campaign_id' => $campaign->id,
            'transaction_code' => 'GS-' . strtoupper(Str::random(10)),
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'payment_proof' => $paymentProof,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('user.donations.thank-you', $transaction)
            ->with('success', 'Donasi berhasil dikirim dan sedang menunggu verifikasi.');
    }

    public function index()
    {
        $transactions = auth()->user()
            ->transactions()
            ->with('campaign')
            ->latest()
            ->paginate(10);

        return view('user.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        abort_unless($transaction->user_id === auth()->id(), 403);

        $transaction->load('campaign');

        return view('user.transactions.show', compact('transaction'));
    }

    public function pdf(Transaction $transaction)
    {
        abort_unless($transaction->user_id === auth()->id(), 403);

        $transaction->load('campaign', 'user');

        $pdf = Pdf::loadView('user.transactions.pdf', compact('transaction'));

        return $pdf->download($transaction->transaction_code . '.pdf');
    }

    public function thankYou(Transaction $transaction)
    {
        abort_unless($transaction->user_id === auth()->id(), 403);

        $transaction->load('campaign');

        return view('user.donations.thank-you', compact('transaction'));
    }
}