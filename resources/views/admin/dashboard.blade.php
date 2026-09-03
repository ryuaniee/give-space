@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
    <div class="mx-auto max-w-7xl">
        <div class="mb-8">
            <h1 class="text-2xl font-semibold tracking-tight text-gray-900">Dashboard</h1>
            <p class="mt-1 text-sm text-gray-500">Ringkasan aktivitas donasi Give Space.</p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-xl border border-gray-200 bg-white p-5">
                <p class="text-sm text-gray-500">Total Donasi</p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-gray-900">Rp {{ number_format($totalDonation, 0, ',', '.') }}</p>
                <p class="mt-1 text-xs text-gray-400">Donasi yang telah diverifikasi</p>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-5">
                <p class="text-sm text-gray-500">Transaksi</p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-gray-900">{{ number_format($totalTransactions) }}</p>
                <p class="mt-1 text-xs text-gray-400">Semua transaksi</p>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-5">
                <p class="text-sm text-gray-500">Campaign Aktif</p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-gray-900">{{ number_format($activeCampaigns) }}</p>
                <p class="mt-1 text-xs text-gray-400">Campaign sedang berjalan</p>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-5">
                <p class="text-sm text-gray-500">Donatur</p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-gray-900">{{ number_format($totalDonors) }}</p>
                <p class="mt-1 text-xs text-gray-400">User terdaftar</p>
            </div>
        </div>

        <div class="mt-6 grid gap-6 lg:grid-cols-3">
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white lg:col-span-2">
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
                    <div>
                        <h2 class="text-sm font-semibold text-gray-900">Transaksi Terbaru</h2>
                        <p class="mt-0.5 text-xs text-gray-500">Lima transaksi terbaru.</p>
                    </div>
                    <a href="{{ route('admin.transactions.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Lihat semua</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Donatur</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Campaign</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Nominal</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($recentTransactions as $transaction)
                                @php
                                    $statusClass = match($transaction->status) {
                                        'verified' => 'bg-green-50 text-green-700',
                                        'rejected' => 'bg-red-50 text-red-700',
                                        default => 'bg-yellow-50 text-yellow-700',
                                    };
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-5 py-4">
                                        <p class="text-sm font-medium text-gray-900">{{ $transaction->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                                    </td>
                                    <td class="max-w-xs px-5 py-4">
                                        <p class="truncate text-sm text-gray-600">{{ $transaction->campaign->title }}</p>
                                    </td>
                                    <td class="whitespace-nowrap px-5 py-4 text-sm font-medium text-gray-900">
                                        Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="whitespace-nowrap px-5 py-4">
                                        <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ $statusClass }}">
                                            {{ ucfirst($transaction->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-12 text-center">
                                        <p class="text-sm font-medium text-gray-900">Belum ada transaksi</p>
                                        <p class="mt-1 text-sm text-gray-500">Transaksi donasi akan muncul di sini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
                <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
                    <div>
                        <h2 class="text-sm font-semibold text-gray-900">Campaign Aktif</h2>
                        <p class="mt-0.5 text-xs text-gray-500">Campaign yang sedang berjalan.</p>
                    </div>
                    <a href="{{ route('admin.campaigns.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Lihat semua</a>
                </div>

                <div class="divide-y divide-gray-100">
                    @forelse($activeCampaignList as $campaign)
                        <div class="px-5 py-4">
                            <p class="text-sm font-medium text-gray-900">{{ $campaign->title }}</p>
                            <p class="mt-1 text-xs text-gray-500">{{ $campaign->category->name }}</p>

                            <div class="mt-3">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="font-medium text-gray-700">Rp {{ number_format($campaign->collected_amount, 0, ',', '.') }}</span>
                                    <span class="text-gray-400">{{ number_format($campaign->progress, 0) }}%</span>
                                </div>
                                <div class="mt-2 h-1.5 overflow-hidden rounded-full bg-gray-100">
                                    <div class="h-full rounded-full bg-indigo-600" style="width: {{ $campaign->progress }}%"></div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-5 py-12 text-center">
                            <p class="text-sm font-medium text-gray-900">Belum ada campaign aktif</p>
                            <p class="mt-1 text-sm text-gray-500">Campaign aktif akan muncul di sini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection