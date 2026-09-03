@extends('layouts.dashboard')

@section('title', 'Detail Donatur')

@section('content')
    <div class="mx-auto max-w-6xl">
        <div class="mb-6">
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-900">
    <i class="bi bi-arrow-left"></i>
    Kembali ke donatur
</a>
            <h1 class="mt-4 text-2xl font-semibold tracking-tight text-gray-900">{{ $user->name }}</h1>
            <p class="mt-1 text-sm text-gray-500">{{ $user->email }}</p>
        </div>

        <div class="grid gap-4 sm:grid-cols-3">
            <div class="rounded-xl border border-gray-200 bg-white p-5">
                <p class="text-sm text-gray-500">Total Donasi</p>
                <p class="mt-2 text-2xl font-semibold text-gray-900">Rp {{ number_format($totalDonation, 0, ',', '.') }}</p>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-5">
                <p class="text-sm text-gray-500">Total Transaksi</p>
                <p class="mt-2 text-2xl font-semibold text-gray-900">{{ $user->transactions()->count() }}</p>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-5">
                <p class="text-sm text-gray-500">Bergabung</p>
                <p class="mt-2 text-2xl font-semibold text-gray-900">{{ $user->created_at->format('d M Y') }}</p>
            </div>
        </div>

        <div class="mt-6 overflow-hidden rounded-xl border border-gray-200 bg-white">
            <div class="border-b border-gray-100 px-5 py-4">
                <h2 class="text-sm font-semibold text-gray-900">Riwayat Donasi</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Transaksi</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Campaign</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Nominal</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($transactions as $transaction)
                            @php
                                $statusClass = match ($transaction->status) {
                                    'verified' => 'bg-green-50 text-green-700',
                                    'rejected' => 'bg-red-50 text-red-700',
                                    default => 'bg-yellow-50 text-yellow-700',
                                };
                            @endphp
                            <tr>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <a href="{{ route('admin.transactions.show', $transaction) }}"
                                        class="text-sm font-medium text-indigo-600 hover:text-indigo-500">{{ $transaction->transaction_code }}</a>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $transaction->campaign->title }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">Rp
                                    {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span
                                        class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ $statusClass }}">{{ ucfirst($transaction->status) }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-sm text-gray-500">Belum ada transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($transactions->hasPages())
                <div class="border-t border-gray-100 px-6 py-4">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection