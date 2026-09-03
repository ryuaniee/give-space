@extends('layouts.dashboard')

@section('title', 'Campaign Donasi')

@section('content')
    <div class="mx-auto max-w-7xl">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight text-gray-900">Campaign Donasi</h1>
                <p class="mt-1 text-sm text-gray-500">Kelola campaign donasi yang tersedia di Give Space.</p>
            </div>
            <a href="{{ route('admin.campaigns.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-800">
                <i class="bi bi-plus-lg"></i>
                Tambah Campaign
            </a>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Campaign</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Target</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Periode</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Status</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($campaigns as $campaign)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-12 w-16 shrink-0 overflow-hidden rounded-lg bg-gray-100">
                                            @if($campaign->image)
                                                <img src="{{ asset('storage/' . $campaign->image) }}" alt="{{ $campaign->title }}"
                                                    class="h-full w-full object-cover">
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <p class="truncate font-medium text-gray-900">{{ $campaign->title }}</p>
                                            <p class="text-sm text-gray-500">{{ $campaign->slug }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">{{ $campaign->category->name }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">Rp
                                    {{ number_format($campaign->target_amount, 0, ',', '.') }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                    {{ $campaign->start_date->format('d M Y') }}
                                    @if($campaign->end_date)
                                        - {{ $campaign->end_date->format('d M Y') }}
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    @php
                                        $statusClass = match ($campaign->status) {
                                            'active' => 'bg-green-50 text-green-700',
                                            'completed' => 'bg-blue-50 text-blue-700',
                                            'closed' => 'bg-gray-100 text-gray-600',
                                            default => 'bg-yellow-50 text-yellow-700',
                                        };
                                    @endphp
                                    <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-medium {{ $statusClass }}">
                                        {{ ucfirst($campaign->status) }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                                    <a href="{{ route('admin.campaigns.edit', $campaign) }}"
                                        class="font-medium text-indigo-600 hover:text-indigo-500">Edit</a>
                                    <form action="{{ route('admin.campaigns.destroy', $campaign) }}" method="POST"
                                        class="ml-4 inline" onsubmit="return confirm('Hapus campaign ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-medium text-red-600 hover:text-red-500">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <p class="text-sm font-medium text-gray-900">Belum ada campaign</p>
                                    <p class="mt-1 text-sm text-gray-500">Buat campaign pertama kamu.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($campaigns->hasPages())
                <div class="border-t border-gray-100 px-6 py-4">
                    {{ $campaigns->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection