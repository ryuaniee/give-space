@extends('layouts.dashboard')

@section('title', 'Transaksi')

@section('content')
    <div class="mx-auto max-w-7xl">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold tracking-tight text-gray-900">Transaksi</h1>
            <p class="mt-1 text-sm text-gray-500">Periksa dan kelola transaksi donasi dari user.</p>
        </div>

        <form method="GET" class="mb-5 rounded-xl border border-gray-200 bg-white p-4">
            <div class="grid gap-3 md:grid-cols-4">
                <div class="md:col-span-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode transaksi, user, atau campaign..." class="block w-full rounded-lg border-0 bg-gray-50 px-3 py-2.5 text-sm text-gray-900 ring-1 ring-inset ring-gray-300 focus:bg-white focus:ring-2 focus:ring-indigo-600">
                </div>

                <div>
                    <select name="status" class="block w-full rounded-lg border-0 bg-gray-50 px-3 py-2.5 text-sm text-gray-900 ring-1 ring-inset ring-gray-300 focus:bg-white focus:ring-2 focus:ring-indigo-600">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Verified</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <div>
                    <select name="payment_method" class="block w-full rounded-lg border-0 bg-gray-50 px-3 py-2.5 text-sm text-gray-900 ring-1 ring-inset ring-gray-300 focus:bg-white focus:ring-2 focus:ring-indigo-600">
                        <option value="">Semua Metode</option>
                        <option value="qris" {{ request('payment_method') === 'qris' ? 'selected' : '' }}>QRIS</option>
                        <option value="bank_transfer" {{ request('payment_method') === 'bank_transfer' ? 'selected' : '' }}>Transfer Rekening</option>
                    </select>
                </div>
            </div>

            <div class="mt-3 flex justify-end gap-2">
                <a href="{{ route('admin.transactions.index') }}" class="rounded-lg px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100">Reset</a>
                <button type="submit" class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-800">Filter</button>
            </div>
        </form>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Transaksi</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Donatur</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Campaign</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Nominal</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Metode</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($transactions as $transaction)
                            @php
                                $statusClass = match($transaction->status) {
                                    'verified' => 'bg-green-50 text-green-700',
                                    'rejected' => 'bg-red-50 text-red-700',
                                    default => 'bg-yellow-50 text-yellow-700',
                                };
                            @endphp
                            <tr class="cursor-pointer hover:bg-gray-50" onclick="window.location='{{ route('admin.transactions.show', $transaction) }}'">
                                <td class="whitespace-nowrap px-6 py-4">
                                    <p class="font-medium text-indigo-600">{{ $transaction->transaction_code }}</p>
                                    <p class="mt-1 text-xs text-gray-400">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-medium text-gray-900">{{ $transaction->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $transaction->user->email }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $transaction->campaign->title }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $transaction->payment_method === 'qris' ? 'QRIS' : 'Transfer Rekening' }}</td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ $statusClass }}">{{ ucfirst($transaction->status) }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <p class="text-sm font-medium text-gray-900">Belum ada transaksi</p>
                                    <p class="mt-1 text-sm text-gray-500">Transaksi donasi akan muncul di sini.</p>
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