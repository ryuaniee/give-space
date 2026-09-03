@extends('layouts.dashboard')

@section('title', 'Kategori Donasi')

@section('content')
    <div class="mx-auto max-w-7xl">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight text-gray-900">Kategori Donasi</h1>
                <p class="mt-1 text-sm text-gray-500">Kelola kategori yang digunakan pada campaign donasi.</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-800">
    <i class="bi bi-plus-lg"></i>
    Tambah Kategori
</a>
        </div>

        {{-- @if(session('success'))
            <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif --}}

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Slug</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($categories as $category)
                            <tr class="hover:bg-gray-50">
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="font-medium text-gray-900">{{ $category->name }}</div>
                                    @if($category->description)
                                        <div class="mt-1 max-w-md truncate text-sm text-gray-500">{{ $category->description }}</div>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $category->slug }}</td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    @if($category->status)
                                        <span class="inline-flex rounded-full bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700">Aktif</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="font-medium text-indigo-600 hover:text-indigo-500">Edit</a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="ml-4 inline" onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-medium text-red-600 hover:text-red-500">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <p class="text-sm font-medium text-gray-900">Belum ada kategori</p>
                                    <p class="mt-1 text-sm text-gray-500">Tambahkan kategori donasi pertama kamu.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($categories->hasPages())
                <div class="border-t border-gray-100 px-6 py-4">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection