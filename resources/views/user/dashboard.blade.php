@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
    <div class="mx-auto max-w-7xl">
        <div class="mb-8">
            <h1 class="text-2xl font-semibold tracking-tight text-gray-900">Halo, {{ auth()->user()->name }}</h1>
            <p class="mt-1 text-sm text-gray-500">Selamat datang kembali di Give Space.</p>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-xl border border-gray-200 bg-white p-5">
                <p class="text-sm text-gray-500">Total Donasi</p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-gray-900">Rp {{ number_format($totalDonation, 0, ',', '.') }}</p>
                <p class="mt-1 text-xs text-gray-400">Donasi yang telah diverifikasi</p>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-5">
                <p class="text-sm text-gray-500">Total Transaksi</p>
                <p class="mt-2 text-2xl font-semibold tracking-tight text-gray-900">{{ number_format($totalTransactions) }}</p>
                <p class="mt-1 text-xs text-gray-400">Semua transaksi donasi</p>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-5">
                <p class="text-sm text-gray-500">Donasi Terakhir</p>
                @if($latestDonation)
                    <p class="mt-2 text-lg font-semibold tracking-tight text-gray-900">Rp {{ number_format($latestDonation->amount, 0, ',', '.') }}</p>
                    <p class="mt-1 truncate text-xs text-gray-400">{{ $latestDonation->campaign->title }}</p>
                @else
                    <p class="mt-2 text-2xl font-semibold tracking-tight text-gray-900">-</p>
                    <p class="mt-1 text-xs text-gray-400">Belum ada transaksi</p>
                @endif
            </div>
        </div>

        <div class="mt-8 flex items-center justify-between">
            <div>
                <h2 class="text-base font-semibold text-gray-900">Campaign Donasi</h2>
                <p class="mt-1 text-sm text-gray-500">Pilih campaign yang ingin kamu dukung.</p>
            </div>
            <a href="{{ route('user.campaigns.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Lihat semua</a>
        </div>

        <div class="mt-4 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($campaigns as $campaign)
                @php
                    $progress = $campaign->target_amount > 0
                        ? min(($campaign->collected_amount / $campaign->target_amount) * 100, 100)
                        : 0;
                @endphp

                <article class="overflow-hidden rounded-xl border border-gray-200 bg-white">
                    <div class="h-44 overflow-hidden bg-gray-100">
                        @if($campaign->image)
                            <img src="{{ asset('storage/' . $campaign->image) }}" alt="{{ $campaign->title }}" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full items-center justify-center">
                                <svg class="h-10 w-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.5 19.5h15M5 16l4-4 3 3 5-6" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <div class="p-5">
                        <p class="text-xs font-medium text-indigo-600">{{ $campaign->category->name }}</p>
                        <h3 class="mt-2 line-clamp-2 font-semibold text-gray-900">{{ $campaign->title }}</h3>
                        <p class="mt-2 line-clamp-2 text-sm text-gray-500">{{ $campaign->description }}</p>

                        <div class="mt-4">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-medium text-gray-700">Rp {{ number_format($campaign->collected_amount, 0, ',', '.') }}</span>
                                <span class="text-gray-400">Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</span>
                            </div>

                            <div class="mt-2 h-1.5 overflow-hidden rounded-full bg-gray-100">
                                <div class="h-full rounded-full bg-indigo-600" style="width: {{ $progress }}%"></div>
                            </div>

                            <p class="mt-2 text-xs text-gray-400">{{ number_format($progress, 0) }}% tercapai</p>
                        </div>

                        <a href="{{ route('user.campaigns.show', $campaign) }}" class="mt-4 block rounded-lg bg-gray-900 px-4 py-2.5 text-center text-sm font-medium text-white hover:bg-gray-800">
                            Lihat Campaign
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-full rounded-xl border border-gray-200 bg-white px-6 py-12 text-center">
                    <p class="text-sm font-medium text-gray-900">Belum ada campaign aktif</p>
                    <p class="mt-1 text-sm text-gray-500">Campaign yang tersedia akan muncul di sini.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8 overflow-hidden rounded-xl border border-gray-200 bg-white">
            <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">
                <div>
                    <h2 class="text-sm font-semibold text-gray-900">Riwayat Donasi Terbaru</h2>
                    <p class="mt-0.5 text-xs text-gray-500">Lima transaksi terakhir kamu.</p>
                </div>
                <a href="{{ route('user.transactions.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Lihat semua</a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Transaksi</th>
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
                                    <a href="{{ route('user.transactions.show', $transaction) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">{{ $transaction->transaction_code }}</a>
                                    <p class="mt-1 text-xs text-gray-400">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                                </td>
                                <td class="px-5 py-4 text-sm text-gray-600">{{ $transaction->campaign->title }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-sm font-medium text-gray-900">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                <td class="whitespace-nowrap px-5 py-4">
                                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ $statusClass }}">{{ ucfirst($transaction->status) }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-12 text-center">
                                    <p class="text-sm font-medium text-gray-900">Belum ada riwayat donasi</p>
                                    <p class="mt-1 text-sm text-gray-500">Transaksi pertama kamu akan muncul di sini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection