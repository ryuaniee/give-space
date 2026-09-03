@extends('layouts.dashboard')

@section('title', 'Riwayat Donasi')

@section('content')
    <div class="mx-auto max-w-7xl">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold tracking-tight text-gray-900">Riwayat Donasi</h1>
            <p class="mt-1 text-sm text-gray-500">Lihat semua transaksi donasi kamu.</p>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Transaksi</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Campaign</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Nominal</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Metode</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($transactions as $transaction)
                            <tr class="hover:bg-gray-50">
                                <td class="whitespace-nowrap px-6 py-4">
                                    <a href="{{ route('user.transactions.show', $transaction) }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                                        {{ $transaction->transaction_code }}
                                    </a>
                                    <p class="mt-1 text-xs text-gray-400">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $transaction->campaign->title }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                    {{ $transaction->payment_method === 'qris' ? 'QRIS' : 'Transfer Rekening' }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    @php
                                        $statusClass = match($transaction->status) {
                                            'verified' => 'bg-green-50 text-green-700',
                                            'rejected' => 'bg-red-50 text-red-700',
                                            default => 'bg-yellow-50 text-yellow-700',
                                        };
                                    @endphp
                                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ $statusClass }}">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <p class="text-sm font-medium text-gray-900">Belum ada transaksi</p>
                                    <p class="mt-1 text-sm text-gray-500">Riwayat donasi kamu akan muncul di sini.</p>
                                </td>
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