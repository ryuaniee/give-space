@extends('layouts.dashboard')

@section('title', 'Donatur')

@section('content')
    <div class="mx-auto max-w-7xl">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold tracking-tight text-gray-900">Donatur</h1>
            <p class="mt-1 text-sm text-gray-500">Daftar user yang terdaftar sebagai donatur.</p>
        </div>

        <form method="GET" class="mb-5 rounded-xl border border-gray-200 bg-white p-4">
            <div class="flex gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="block min-w-0 flex-1 rounded-lg border-0 bg-gray-50 px-3 py-2.5 text-sm text-gray-900 ring-1 ring-inset ring-gray-300 focus:bg-white focus:ring-2 focus:ring-indigo-600">
                <button type="submit" class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-800">Cari</button>
            </div>
        </form>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Donatur</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Transaksi</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Transaksi Berhasil</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Bergabung</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gray-900 text-sm font-semibold text-white">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">{{ $user->transactions_count }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">{{ $user->verified_transactions_count }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <a href="{{ route('admin.users.show', $user) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <p class="text-sm font-medium text-gray-900">Belum ada donatur</p>
                                    <p class="mt-1 text-sm text-gray-500">User yang melakukan pendaftaran akan muncul di sini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="border-t border-gray-100 px-6 py-4">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection