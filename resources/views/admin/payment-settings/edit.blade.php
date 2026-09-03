@extends('layouts.dashboard')

@section('title', 'Pengaturan Pembayaran')

@section('content')
    <div class="mx-auto max-w-4xl">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold tracking-tight text-gray-900">Pengaturan Pembayaran</h1>
            <p class="mt-1 text-sm text-gray-500">Atur QRIS dan rekening yang akan digunakan untuk menerima donasi.</p>
        </div>

        <form action="{{ route('admin.payment-settings.update') }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT')

            <div class="rounded-xl border border-gray-200 bg-white p-6">
                <h2 class="text-base font-semibold text-gray-900">QRIS</h2>
                <p class="mt-1 text-sm text-gray-500">QRIS ini akan ditampilkan kepada user saat memilih metode pembayaran
                    QRIS.</p>

                <div class="mt-5">
                    @if($paymentSetting->qris_image)
                        <div class="mb-4">
                            <p class="mb-2 text-sm font-medium text-gray-900">QRIS Saat Ini</p>
                            <div
                                class="flex h-56 w-56 items-center justify-center overflow-hidden rounded-lg border border-gray-200 bg-gray-50 p-3">
                                <img src="{{ asset('storage/' . $paymentSetting->qris_image) }}" alt="QRIS"
                                    class="h-full w-full object-contain">
                            </div>
                        </div>
                    @endif

                    <label for="qris_image" class="block text-sm font-medium text-gray-900">Upload QRIS</label>
                    <input type="file" id="qris_image" name="qris_image" accept="image/*"
                        class="mt-2 block w-full rounded-lg bg-gray-50 text-sm text-gray-600 file:mr-4 file:border-0 file:bg-gray-900 file:px-4 file:py-2.5 file:text-sm file:font-medium file:text-white hover:file:bg-gray-800">
                    <p class="mt-1 text-xs text-gray-400">JPG, JPEG, PNG, WEBP. Maksimal 2 MB.</p>

                    @error('qris_image')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-6">
                <h2 class="text-base font-semibold text-gray-900">Transfer Rekening</h2>
                <p class="mt-1 text-sm text-gray-500">Informasi rekening yang akan ditampilkan kepada user.</p>

                <div class="mt-5 grid gap-5 md:grid-cols-2">
                    <div>
                        <label for="bank_name" class="block text-sm font-medium text-gray-900">Nama Bank</label>
                        <input type="text" id="bank_name" name="bank_name"
                            value="{{ old('bank_name', $paymentSetting->bank_name) }}" placeholder="Contoh: BCA"
                            class="mt-2 block w-full rounded-lg border-0 bg-gray-50 px-3 py-2.5 text-sm text-gray-900 ring-1 ring-inset ring-gray-300 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-indigo-600">
                        @error('bank_name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="account_number" class="block text-sm font-medium text-gray-900">Nomor Rekening</label>
                        <input type="text" id="account_number" name="account_number"
                            value="{{ old('account_number', $paymentSetting->account_number) }}"
                            placeholder="Contoh: 1234567890"
                            class="mt-2 block w-full rounded-lg border-0 bg-gray-50 px-3 py-2.5 text-sm text-gray-900 ring-1 ring-inset ring-gray-300 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-indigo-600">
                        @error('account_number')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="account_name" class="block text-sm font-medium text-gray-900">Atas Nama</label>
                        <input type="text" id="account_name" name="account_name"
                            value="{{ old('account_name', $paymentSetting->account_name) }}"
                            placeholder="Contoh: Yayasan Give Space"
                            class="mt-2 block w-full rounded-lg border-0 bg-gray-50 px-3 py-2.5 text-sm text-gray-900 ring-1 ring-inset ring-gray-300 focus:bg-white focus:ring-2 focus:ring-inset focus:ring-indigo-600">
                        @error('account_name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-800">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection