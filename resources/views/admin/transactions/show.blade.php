@extends('layouts.dashboard')

@section('title', 'Detail Transaksi')

@section('content')
    <div class="mx-auto max-w-5xl">
        <div class="mb-6">
            <a href="{{ route('admin.transactions.index') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-900">
                <i class="bi bi-arrow-left"></i>
                Kembali ke transaksi
            </a>

            <div class="mt-4 flex items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-semibold tracking-tight text-gray-900">Detail Transaksi</h1>
                    <p class="mt-1 text-sm text-gray-500">{{ $transaction->transaction_code }}</p>
                </div>

                <a href="{{ route('admin.transactions.pdf', $transaction) }}"
                    class="inline-flex shrink-0 items-center gap-2 rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    <i class="bi bi-file-earmark-pdf"></i>
                    Cetak Transaksi
                </a>
            </div>

            @php
                $statusClass = match ($transaction->status) {
    'verified' => 'bg-green-100 text-green-700 border border-green-200',
    'rejected' => 'bg-red-100 text-red-700 border border-red-200',
    default => 'bg-yellow-100 text-yellow-700 border border-yellow-200',
};
            @endphp

            <div class="mt-3">
                <span class="rounded-full px-3 py-1 text-xs font-medium {{ $statusClass }}">
                    {{ ucfirst($transaction->status) }}
                </span>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="space-y-6 lg:col-span-2">
                <div class="rounded-xl border border-gray-200 bg-white p-6">
                    <h2 class="text-base font-semibold text-gray-900">Informasi Donasi</h2>

                    <dl class="mt-5 grid gap-5 sm:grid-cols-2">
                        <div>
                            <dt class="text-xs text-gray-500">Donatur</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-900">{{ $transaction->user->name }}</dd>
                        </div>

                        <div>
                            <dt class="text-xs text-gray-500">Email</dt>
                            <dd class="mt-1 text-sm text-gray-700">{{ $transaction->user->email }}</dd>
                        </div>

                        <div>
                            <dt class="text-xs text-gray-500">Campaign</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-900">{{ $transaction->campaign->title }}</dd>
                        </div>

                        <div>
                            <dt class="text-xs text-gray-500">Nominal</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">Rp
                                {{ number_format($transaction->amount, 0, ',', '.') }}</dd>
                        </div>

                        <div>
                            <dt class="text-xs text-gray-500">Metode Pembayaran</dt>
                            <dd class="mt-1 text-sm text-gray-700">
                                {{ $transaction->payment_method === 'qris' ? 'QRIS' : 'Transfer Rekening' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs text-gray-500">Tanggal</dt>
                            <dd class="mt-1 text-sm text-gray-700">{{ $transaction->created_at->format('d M Y, H:i') }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-6">
                    <h2 class="text-base font-semibold text-gray-900">Bukti Pembayaran</h2>

                    <div class="mt-4 flex justify-center rounded-lg bg-gray-50 p-4">
                        <img src="{{ asset('storage/' . $transaction->payment_proof) }}"
                            alt="Bukti pembayaran {{ $transaction->transaction_code }}"
                            class="max-h-[600px] max-w-full rounded-lg object-contain">
                    </div>
                </div>
            </div>

            <div>
                @if($transaction->status === 'pending')
                    <div class="rounded-xl border border-gray-200 bg-white p-6">
                        <h2 class="text-base font-semibold text-gray-900">Tindakan</h2>
                        <p class="mt-1 text-sm text-gray-500">Pastikan bukti pembayaran valid sebelum melakukan verifikasi.</p>

                        <form action="{{ route('admin.transactions.verify', $transaction) }}" method="POST" class="mt-6"
                            onsubmit="return confirm('Verifikasi transaksi ini?')">
                            @csrf
                            <button type="submit"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-800">
                                <i class="bi bi-check-lg"></i>
                                Verifikasi Transaksi
                            </button>
                        </form>

                        <div class="my-5 border-t border-gray-100"></div>

                        <form action="{{ route('admin.transactions.reject', $transaction) }}" method="POST">
                            @csrf

                            <label for="rejection_reason" class="block text-sm font-medium text-gray-900">
                                Alasan Penolakan
                            </label>

                            <textarea id="rejection_reason" name="rejection_reason" rows="4" required
                                placeholder="Contoh: Bukti pembayaran tidak sesuai..."
                                class="mt-2 block w-full rounded-lg border-0 bg-gray-50 px-3 py-2.5 text-sm text-gray-900 ring-1 ring-inset ring-gray-300 focus:bg-white focus:ring-2 focus:ring-indigo-600">{{ old('rejection_reason') }}</textarea>

                            @error('rejection_reason')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <button type="submit"
                                class="mt-3 inline-flex w-full items-center justify-center gap-2 rounded-lg border border-red-200 px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50">
                                <i class="bi bi-x-lg"></i>
                                Tolak Transaksi
                            </button>
                        </form>
                    </div>
                @elseif($transaction->status === 'rejected')
                    <div class="rounded-xl border border-red-100 bg-red-50 p-6">
                        <div class="flex items-center gap-2">
                            <i class="bi bi-x-circle text-red-600"></i>
                            <h2 class="text-base font-semibold text-red-900">Transaksi Ditolak</h2>
                        </div>
                        <p class="mt-2 text-sm text-red-700">{{ $transaction->rejection_reason }}</p>
                    </div>
                @else
                    <div class="rounded-xl border border-green-100 bg-green-50 p-6">
                        <div class="flex items-center gap-2">
                            <i class="bi bi-check-circle text-green-600"></i>
                            <h2 class="text-base font-semibold text-green-900">Transaksi Terverifikasi</h2>
                        </div>
                        @if($transaction->verified_at)
                            <p class="mt-2 text-sm text-green-700">
                                Diverifikasi pada {{ $transaction->verified_at->format('d M Y, H:i') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection