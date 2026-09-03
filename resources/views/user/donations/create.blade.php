@extends('layouts.dashboard')

@section('title', 'Donasi')

@section('content')
    <div class="mx-auto max-w-3xl">
        <div class="mb-6">
            <a href="{{ route('user.dashboard') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-900">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>
            <h1 class="mt-4 text-2xl font-semibold tracking-tight text-gray-900">Donasi Sekarang</h1>
            <p class="mt-1 text-sm text-gray-500">Dukung campaign "{{ $campaign->title }}".</p>
        </div>

        <div class="mb-6 rounded-xl border border-gray-200 bg-white p-5">
            <p class="text-xs font-medium uppercase tracking-wider text-indigo-600">{{ $campaign->category->name }}</p>
            <h2 class="mt-2 text-lg font-semibold text-gray-900">{{ $campaign->title }}</h2>
        </div>

        <form action="{{ route('user.donations.store', $campaign) }}" method="POST" enctype="multipart/form-data"
            class="rounded-xl border border-gray-200 bg-white p-6">
            @csrf

            <div class="space-y-6">
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-900">
                        Nominal Donasi
                    </label>

                    <div class="relative mt-2">
                        <span
                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-sm text-gray-500">
                            Rp
                        </span>

                        <input type="text" id="amount" name="amount" value="{{ old('amount') }}" required
                            inputmode="numeric" placeholder="100.000"
                            class="block w-full rounded-lg border-0 bg-gray-50 py-2.5 pl-10 pr-3 text-sm text-gray-900 ring-1 ring-inset ring-gray-300 focus:bg-white focus:ring-2 focus:ring-indigo-600">
                    </div> @error('amount')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-900">Metode Pembayaran</label>

                    <div class="mt-3 grid gap-3 sm:grid-cols-2">
                        <label class="cursor-pointer">
                            <input type="radio" name="payment_method" value="qris" class="peer sr-only" {{ old('payment_method') === 'qris' ? 'checked' : '' }}>
                            <div
                                class="rounded-xl border border-gray-200 p-4 transition peer-checked:border-indigo-600 peer-checked:bg-indigo-50 hover:border-gray-300">
                                <p class="font-medium text-gray-900">QRIS</p>
                                <p class="mt-1 text-sm text-gray-500">Bayar menggunakan QRIS.</p>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="payment_method" value="bank_transfer" class="peer sr-only" {{ old('payment_method') === 'bank_transfer' ? 'checked' : '' }}>
                            <div
                                class="rounded-xl border border-gray-200 p-4 transition peer-checked:border-indigo-600 peer-checked:bg-indigo-50 hover:border-gray-300">
                                <p class="font-medium text-gray-900">Transfer Rekening</p>
                                <p class="mt-1 text-sm text-gray-500">Transfer melalui rekening bank.</p>
                            </div>
                        </label>
                    </div>

                    @error('payment_method')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div id="qris-payment" class="hidden rounded-xl bg-gray-50 p-5">
                    @if($paymentSetting?->qris_image)
                        <p class="mb-3 text-sm font-medium text-gray-900">Scan QRIS berikut</p>
                        <div class="flex justify-center">
                            <img src="{{ asset('storage/' . $paymentSetting->qris_image) }}" alt="QRIS"
                                class="h-64 w-64 rounded-lg border border-gray-200 bg-white object-contain p-2">
                        </div>
                    @else
                        <p class="text-sm text-red-600">QRIS belum tersedia.</p>
                    @endif
                </div>

                <div id="bank-payment" class="hidden rounded-xl bg-gray-50 p-5">
                    <p class="mb-4 text-sm font-medium text-gray-900">Transfer ke rekening berikut</p>

                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-gray-500">Bank</p>
                            <p class="mt-1 font-medium text-gray-900">{{ $paymentSetting?->bank_name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Nomor Rekening</p>
                            <p class="mt-1 font-medium text-gray-900">{{ $paymentSetting?->account_number ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Atas Nama</p>
                            <p class="mt-1 font-medium text-gray-900">{{ $paymentSetting?->account_name ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="payment_proof" class="block text-sm font-medium text-gray-900">Bukti Pembayaran</label>
                    <input type="file" id="payment_proof" name="payment_proof" accept="image/*" required
                        class="mt-2 block w-full rounded-lg bg-gray-50 text-sm text-gray-600 file:mr-4 file:border-0 file:bg-gray-900 file:px-4 file:py-2.5 file:text-sm file:font-medium file:text-white hover:file:bg-gray-800">
                    <p class="mt-1 text-xs text-gray-400">JPG, JPEG, PNG, WEBP. Maksimal 2 MB.</p>
                    @error('payment_proof')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-8 flex justify-end border-t border-gray-100 pt-6">
                <button type="submit"
                    class="rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-800">
                    Kirim Donasi
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        const methods = document.querySelectorAll('input[name="payment_method"]');
        const qrisPayment = document.getElementById('qris-payment');
        const bankPayment = document.getElementById('bank-payment');

        function updatePaymentMethod() {
            const selected = document.querySelector('input[name="payment_method"]:checked')?.value;
            qrisPayment.classList.toggle('hidden', selected !== 'qris');
            bankPayment.classList.toggle('hidden', selected !== 'bank_transfer');
        }

        methods.forEach((method) => method.addEventListener('change', updatePaymentMethod));
        updatePaymentMethod();
    </script>
    <script>
        const amountInput = document.getElementById('amount');

        amountInput.addEventListener('input', function () {
            let value = this.value.replace(/\D/g, '');

            this.value = value
                ? new Intl.NumberFormat('id-ID').format(value)
                : '';
        });

        document.querySelector('form').addEventListener('submit', function () {
            amountInput.value = amountInput.value.replace(/\./g, '');
        });
    </script>
@endpush