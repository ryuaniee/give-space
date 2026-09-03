@extends('layouts.dashboard')

@section('title', $campaign->title)

@section('content')
    <div class="mx-auto max-w-5xl">
        <a href="{{ route('user.campaigns.index') }}"
            class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-900">
            <i class="bi bi-arrow-left"></i>
            Kembali ke campaign
        </a>

        <div class="mt-5 overflow-hidden rounded-xl border border-gray-200 bg-white">
            @if($campaign->image)
                <img src="{{ asset('storage/' . $campaign->image) }}" alt="{{ $campaign->title }}"
                    class="h-72 w-full object-cover md:h-96">
            @endif

            <div class="p-6 md:p-8">
                <p class="text-sm font-medium text-indigo-600">{{ $campaign->category->name }}</p>
                <h1 class="mt-2 text-2xl font-semibold tracking-tight text-gray-900 md:text-3xl">{{ $campaign->title }}</h1>

                <div class="mt-6">
                    <div class="flex items-end justify-between gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Terkumpul</p>
                            <p class="mt-1 text-2xl font-semibold text-gray-900">Rp
                                {{ number_format($collectedAmount, 0, ',', '.') }}
                            </p>
                        </div>
                        <p class="text-sm text-gray-500">Target Rp
                            {{ number_format($campaign->target_amount, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="mt-3 h-2 overflow-hidden rounded-full bg-gray-100">
                        <div class="h-full rounded-full bg-indigo-600" style="width: {{ $progress }}%"></div>
                    </div>

                    <p class="mt-2 text-sm text-gray-500">{{ number_format($progress, 0) }}% dari target</p>
                </div>

                <div class="mt-8 border-t border-gray-100 pt-8">
                    <h2 class="text-base font-semibold text-gray-900">Tentang Campaign</h2>
                    <div class="mt-3 whitespace-pre-line text-sm leading-7 text-gray-600">{{ $campaign->description }}</div>
                </div>

                <div class="mt-8 border-t border-gray-100 pt-6">
                    <a href="{{ route('user.donations.create', $campaign) }}"
                        class="inline-flex rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-800">
                        Donasi Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection