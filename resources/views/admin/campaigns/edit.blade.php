@extends('layouts.dashboard')

@section('title', 'Edit Campaign')

@section('content')
    <div class="mx-auto max-w-4xl">
        <div class="mb-6">
            <a href="{{ route('admin.campaigns.index') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-900">
                <i class="bi bi-arrow-left"></i>
                Kembali ke campaign
            </a>
            <h1 class="mt-4 text-2xl font-semibold tracking-tight text-gray-900">Edit Campaign</h1>
            <p class="mt-1 text-sm text-gray-500">Perbarui informasi campaign.</p>
        </div>

        <form action="{{ route('admin.campaigns.update', $campaign) }}" method="POST" enctype="multipart/form-data"
            class="rounded-xl border border-gray-200 bg-white p-6">
            @csrf
            @method('PUT')

            <div class="grid gap-6 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-900">Judul Campaign</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $campaign->title) }}" required
                        class="mt-2 block w-full rounded-lg border-0 bg-gray-50 px-3 py-2.5 text-sm ring-1 ring-inset ring-gray-300 focus:bg-white focus:ring-2 focus:ring-indigo-600">
                    @error('title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-900">Kategori</label>
                    <select id="category_id" name="category_id" required
                        class="mt-2 block w-full rounded-lg border-0 bg-gray-50 px-3 py-2.5 text-sm ring-1 ring-inset ring-gray-300 focus:bg-white focus:ring-2 focus:ring-indigo-600">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $campaign->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="target_amount" class="block text-sm font-medium text-gray-900">Target Donasi</label>
                    <input type="text" id="target_amount" name="target_amount"
                        value="{{ old('target_amount', number_format($campaign->target_amount, 0, ',', '.')) }}" required
                        inputmode="numeric" placeholder="Contoh: 1.000.000.000"
                        class="mt-2 block w-full rounded-lg border-0 bg-gray-50 px-3 py-2.5 text-sm ring-1 ring-inset ring-gray-300 focus:bg-white focus:ring-2 focus:ring-indigo-600">
                    @error('target_amount')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-900">Tanggal Mulai</label>
                    <input type="date" id="start_date" name="start_date"
                        value="{{ old('start_date', $campaign->start_date?->format('Y-m-d')) }}" required
                        class="mt-2 block w-full rounded-lg border-0 bg-gray-50 px-3 py-2.5 text-sm ring-1 ring-inset ring-gray-300 focus:bg-white focus:ring-2 focus:ring-indigo-600">
                    @error('start_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-900">Tanggal Selesai</label>
                    <input type="date" id="end_date" name="end_date"
                        value="{{ old('end_date', $campaign->end_date?->format('Y-m-d')) }}"
                        class="mt-2 block w-full rounded-lg border-0 bg-gray-50 px-3 py-2.5 text-sm ring-1 ring-inset ring-gray-300 focus:bg-white focus:ring-2 focus:ring-indigo-600">
                    @error('end_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-900">Status</label>
                    <select id="status" name="status" required
                        class="mt-2 block w-full rounded-lg border-0 bg-gray-50 px-3 py-2.5 text-sm ring-1 ring-inset ring-gray-300 focus:bg-white focus:ring-2 focus:ring-indigo-600">
                        <option value="draft" {{ old('status', $campaign->status) === 'draft' ? 'selected' : '' }}>Draft
                        </option>
                        <option value="active" {{ old('status', $campaign->status) === 'active' ? 'selected' : '' }}>Aktif
                        </option>
                        <option value="completed" {{ old('status', $campaign->status) === 'completed' ? 'selected' : '' }}>
                            Selesai</option>
                        <option value="closed" {{ old('status', $campaign->status) === 'closed' ? 'selected' : '' }}>Ditutup
                        </option>
                    </select>
                    @error('status')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-900">Ganti Gambar</label>
                    <input type="file" id="image" name="image" accept="image/*"
                        class="mt-2 block w-full rounded-lg bg-gray-50 text-sm text-gray-600 file:mr-4 file:border-0 file:bg-gray-900 file:px-4 file:py-2.5 file:text-sm file:font-medium file:text-white hover:file:bg-gray-800">
                    <p class="mt-1 text-xs text-gray-400">Biarkan kosong jika tidak ingin mengganti.</p>
                    @error('image')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                @if($campaign->image)
                    <div class="md:col-span-2">
                        <p class="mb-2 text-sm font-medium text-gray-900">Gambar Saat Ini</p>
                        <img src="{{ asset('storage/' . $campaign->image) }}" alt="{{ $campaign->title }}"
                            class="h-48 w-full rounded-lg object-cover md:w-80">
                    </div>
                @endif

                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-900">Deskripsi Campaign</label>
                    <textarea id="description" name="description" rows="7" required
                        class="mt-2 block w-full rounded-lg border-0 bg-gray-50 px-3 py-2.5 text-sm ring-1 ring-inset ring-gray-300 focus:bg-white focus:ring-2 focus:ring-indigo-600">{{ old('description', $campaign->description) }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3 border-t border-gray-100 pt-6">
                <a href="{{ route('admin.campaigns.index') }}"
                    class="rounded-lg px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-100">Batal</a>
                <button type="submit"
                    class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white hover:bg-gray-800">Simpan
                    Perubahan</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        const targetAmount = document.getElementById('target_amount');

        targetAmount.addEventListener('input', function () {
            let value = this.value.replace(/\D/g, '');

            this.value = value
                ? new Intl.NumberFormat('id-ID').format(value)
                : '';
        });

        document.querySelector('form').addEventListener('submit', function () {
            targetAmount.value = targetAmount.value.replace(/\./g, '');
        });
    </script>
@endpush