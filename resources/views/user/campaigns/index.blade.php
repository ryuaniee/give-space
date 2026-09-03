@extends('layouts.dashboard')

@section('title', 'Campaign Donasi')

@section('content')
    <div class="mx-auto max-w-7xl">
        <div class="mb-8">
            <h1 class="text-2xl font-semibold tracking-tight text-gray-900">Campaign Donasi</h1>
            <p class="mt-1 text-sm text-gray-500">Temukan campaign dan dukung mereka yang membutuhkan.</p>
        </div>

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($campaigns as $campaign)
                @php
                    $collectedAmount = $campaign->transactions()
                        ->where('status', 'verified')
                        ->sum('amount');

                    $progress = $campaign->target_amount > 0
                        ? min(($collectedAmount / $campaign->target_amount) * 100, 100)
                        : 0;
                @endphp

                <article class="overflow-hidden rounded-xl border border-gray-200 bg-white">
                    <div class="h-48 overflow-hidden bg-gray-100">
                        @if($campaign->image)
                            <img src="{{ asset('storage/' . $campaign->image) }}" alt="{{ $campaign->title }}"
                                class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full items-center justify-center">
                                <svg class="h-10 w-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4.5 19.5h15M5 16l4-4 3 3 5-6" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <div class="p-5">
                        <p class="text-xs font-medium text-indigo-600">{{ $campaign->category->name }}</p>
                        <h2 class="mt-2 line-clamp-2 text-lg font-semibold text-gray-900">{{ $campaign->title }}</h2>
                        <p class="mt-2 line-clamp-2 text-sm text-gray-500">{{ $campaign->description }}</p>

                        <div class="mt-5">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-semibold text-gray-900">Rp
                                    {{ number_format($collectedAmount, 0, ',', '.') }}</span>
                                <span class="text-gray-500">dari Rp
                                    {{ number_format($campaign->target_amount, 0, ',', '.') }}</span>
                            </div>

                            <div class="mt-2 h-1.5 overflow-hidden rounded-full bg-gray-100">
                                <div class="h-full rounded-full bg-indigo-600" style="width: {{ $progress }}%"></div>
                            </div>

                            <p class="mt-2 text-xs text-gray-400">{{ number_format($progress, 0) }}% tercapai</p>
                        </div>

                        <a href="{{ route('user.campaigns.show', $campaign) }}"
                            class="mt-5 block rounded-lg bg-gray-900 px-4 py-2.5 text-center text-sm font-medium text-white hover:bg-gray-800">
                            Lihat Campaign
                        </a>
                    </div>
                </article>
            @empty
                <div class="col-span-full rounded-xl border border-gray-200 bg-white px-6 py-16 text-center">
                    <p class="text-sm font-medium text-gray-900">Belum ada campaign aktif</p>
                    <p class="mt-1 text-sm text-gray-500">Campaign yang tersedia akan muncul di sini.</p>
                </div>
            @endforelse
        </div>

        @if($campaigns->hasPages())
            <div class="mt-6">
                {{ $campaigns->links() }}
            </div>
        @endif
    </div>
@endsection