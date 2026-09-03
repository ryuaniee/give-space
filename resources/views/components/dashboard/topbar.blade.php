<header class="sticky top-0 z-30 h-16 border-b border-gray-200 bg-white/95 backdrop-blur">
    <div class="flex h-full items-center justify-between px-6 lg:px-8">
        <div>
            {{-- <p class="text-sm text-gray-500">{{ now()->format('l, d F Y') }}</p> --}}
        </div>


        <div class="flex items-center gap-3">
            <div class="hidden text-right sm:block">
                <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                <p class="text-xs capitalize text-gray-500">{{ auth()->user()->role }}</p>
            </div>
            <div
                class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-900 text-sm font-semibold text-white">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
        </div>
    </div>


</header>