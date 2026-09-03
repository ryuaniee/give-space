@if(session('success') || session('error') || session('warning') || session('info'))
    <div id="toast-container" class="fixed right-5 bottom-5 z-50 flex w-full max-w-sm flex-col gap-3">
        @if(session('success'))
            <div class="toast-item flex items-start gap-3 rounded-xl border border-gray-200 bg-white p-4 shadow-lg">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-green-50 text-green-600">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 12 4 4L19 6" />
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-gray-900">Berhasil</p>
                    <p class="mt-0.5 text-sm text-gray-500">{{ session('success') }}</p>
                </div>
                <button type="button" onclick="this.closest('.toast-item').remove()" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="toast-item flex items-start gap-3 rounded-xl border border-gray-200 bg-white p-4 shadow-lg">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-red-50 text-red-600">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-gray-900">Terjadi Kesalahan</p>
                    <p class="mt-0.5 text-sm text-gray-500">{{ session('error') }}</p>
                </div>
                <button type="button" onclick="this.closest('.toast-item').remove()" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        @if(session('warning'))
            <div class="toast-item flex items-start gap-3 rounded-xl border border-gray-200 bg-white p-4 shadow-lg">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-yellow-50 text-yellow-600">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v4m0 4h.01M10.3 3.9l-8 14a2 2 0 0 0 1.7 3h16a2 2 0 0 0 1.7-3l-8-14a2 2 0 0 0-3.4 0Z" />
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-gray-900">Perhatian</p>
                    <p class="mt-0.5 text-sm text-gray-500">{{ session('warning') }}</p>
                </div>
                <button type="button" onclick="this.closest('.toast-item').remove()" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        @if(session('info'))
            <div class="toast-item flex items-start gap-3 rounded-xl border border-gray-200 bg-white p-4 shadow-lg">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-blue-50 text-blue-600">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8h.01M11 12h1v4h1m8-4a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-semibold text-gray-900">Informasi</p>
                    <p class="mt-0.5 text-sm text-gray-500">{{ session('info') }}</p>
                </div>
                <button type="button" onclick="this.closest('.toast-item').remove()" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif
    </div>

    <script>
        document.querySelectorAll('.toast-item').forEach((toast) => {
            setTimeout(() => {
                toast.remove();
            }, 4000);
        });
    </script>
@endif