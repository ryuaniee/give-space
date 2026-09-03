@extends('layouts.dashboard')

@section('title', 'Detail Transaksi')

@section('content')
    <div class="mx-auto max-w-3xl">
        <div class="mb-6">
            <a href="{{ route('user.transactions.index') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-900">
                <i class="bi bi-arrow-left"></i>
                Kembali ke riwayat
            </a>

            <div class="mt-4 flex items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-semibold tracking-tight text-gray-900">Detail Transaksi</h1>
                </div>

                <a href="{{ route('user.transactions.pdf', $transaction) }}"
                    class="inline-flex shrink-0 items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <i class="bi bi-file-earmark-pdf"></i>
                    Cetak Transaksi
                </a>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white">
            <div class="flex items-center justify-between border-b border-gray-100 px-6 py-5">
                <div>
                    <p class="text-xs text-gray-500">Kode Transaksi</p>
                    <p class="mt-1 font-semibold text-gray-900">{{ $transaction->transaction_code }}</p>
                </div>

                @php
                    $statusClass = match ($transaction->status) {
                        'verified' => 'bg-green-50 text-green-700',
                        'rejected' => 'bg-red-50 text-red-700',
                        default => 'bg-yellow-50 text-yellow-700',
                    };
                @endphp

                <span class="rounded-full px-3 py-1 text-xs font-medium {{ $statusClass }}">
                    {{ ucfirst($transaction->status) }}
                </span>
            </div>

            <div class="space-y-5 p-6">
                <div>
                    <p class="text-xs text-gray-500">Campaign</p>
                    <p class="mt-1 font-medium text-gray-900">{{ $transaction->campaign->title }}</p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Nominal Donasi</p>
                    <p class="mt-1 text-xl font-semibold text-gray-900">
                        Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Metode Pembayaran</p>
                    <p class="mt-1 font-medium text-gray-900">
                        {{ $transaction->payment_method === 'qris' ? 'QRIS' : 'Transfer Rekening' }}
                    </p>
                </div>

                @if($transaction->status === 'rejected' && $transaction->rejection_reason)
                    <div class="rounded-lg bg-red-50 p-4">
                        <p class="text-sm font-medium text-red-800">Alasan Penolakan</p>
                        <p class="mt-1 text-sm text-red-700">{{ $transaction->rejection_reason }}</p>
                    </div>
                @endif

                <div>
                    <p class="mb-2 text-xs text-gray-500">Bukti Pembayaran</p>
                    <img src="{{ asset('storage/' . $transaction->payment_proof) }}"
                        alt="Bukti pembayaran {{ $transaction->transaction_code }}"
                        class="max-h-[500px] rounded-lg border border-gray-200 object-contain">
                </div>
            </div>
        </div>
    </div>
@endsection