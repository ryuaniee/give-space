@extends('layouts.dashboard')

@section('title', 'Edit Kategori')

@section('content')
    <div class="mx-auto max-w-3xl">
        <div class="mb-6">
            <a href="{{ route('admin.categories.index') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-900">
                <i class="bi bi-arrow-left"></i>
                Kembali ke kategori
            </a>
            <h1 class="mt-4 text-2xl font-semibold tracking-tight text-gray-900">Edit Kategori</h1>
            <p class="mt-1 text-sm text-gray-500">Perbarui informasi kategori donasi.</p>
        </div>

        <form action="{{ route('admin.categories.update', $category) }}" method="POST"
            class="rounded-xl border border-gray-200 bg-white p-6">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-900">Nama Kategori</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required
                        class="mt-2 block w-full rounded-lg border-0 bg-gray-50 px-3 py-2.5 text-sm text-gray-900 ring-1 ring-inset ring-gray-300 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-indigo-600">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-900">Deskripsi</label>
                    <textarea id="description" name="description" rows="4"
                        class="mt-2 block w-full rounded-lg border-0 bg-gray-50 px-3 py-2.5 text-sm text-gray-900 ring-1 ring-inset ring-gray-300 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-indigo-600">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-900">Status</label>
                    <select id="status" name="status"
                        class="mt-2 block w-full rounded-lg border-0 bg-gray-50 px-3 py-2.5 text-sm text-gray-900 ring-1 ring-inset ring-gray-300 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-indigo-600">
                        <option value="1" {{ old('status', $category->status) == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('status', $category->status) == '0' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('status')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3 border-t border-gray-100 pt-6">
                <a href="{{ route('admin.categories.index') }}"
                    class="rounded-lg px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100">Batal</a>
                <button type="submit"
                    class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-800">Simpan
                    Perubahan</button>
            </div>
        </form>
    </div>
@endsection