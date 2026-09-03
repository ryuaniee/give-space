<aside class="fixed inset-y-0 left-0 z-40 hidden w-64 border-r border-gray-200 bg-white lg:block">
    <div class="flex h-full flex-col">
        <div class="flex h-16 items-center border-b border-gray-100 px-6">
            <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}"
                class="text-xl font-bold tracking-tight text-gray-900">
                Give Space
            </a>
        </div>

        <div class="flex-1 overflow-y-auto px-4 py-6">
            @if(auth()->user()->role === 'admin')
                <p class="mb-3 px-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Administration</p>

                <nav class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <i class="bi bi-speedometer2 w-5 text-center text-base"></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('admin.categories.index') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.categories.*') ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <i class="bi bi-grid w-5 text-center text-base"></i>
                        <span>Kategori Donasi</span>
                    </a>

                    <a href="{{ route('admin.campaigns.index') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.campaigns.*') ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <i class="bi bi-heart w-5 text-center text-base"></i>
                        <span>Campaign Donasi</span>
                    </a>

                    <a href="{{ route('admin.transactions.index') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.transactions.*') ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <i class="bi bi-receipt w-5 text-center text-base"></i>
                        <span class="flex-1">Transaksi</span>

                        @if($pendingTransactions > 0)
                            <span
                                class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-red-500 text-[10px] font-semibold leading-none text-white">
                                {{ $pendingTransactions > 99 ? '99+' : $pendingTransactions }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.users.*') ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <i class="bi bi-people w-5 text-center text-base"></i>
                        <span>Donatur</span>
                    </a>

                    <a href="{{ route('admin.payment-settings.edit') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('admin.payment-settings.*') ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <i class="bi bi-credit-card w-5 text-center text-base"></i>
                        <span>Pengaturan Pembayaran</span>
                    </a>
                </nav>
            @else
                <p class="mb-3 px-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Menu</p>

                <nav class="space-y-1">
                    <a href="{{ route('user.dashboard') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('user.dashboard') ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <i class="bi bi-speedometer2 w-5 text-center text-base"></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('user.campaigns.index') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('user.campaigns.*') ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <i class="bi bi-heart w-5 text-center text-base"></i>
                        <span>Campaign Donasi</span>
                    </a>

                    <a href="{{ route('user.transactions.index') }}"
                        class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ request()->routeIs('user.transactions.*') ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                        <i class="bi bi-clock-history w-5 text-center text-base"></i>
                        <span>Riwayat Donasi</span>
                    </a>
                </nav>
            @endif
        </div>

        <div class="border-t border-gray-100 p-4">
            <div class="mb-3 flex items-center gap-3 px-2">
                <div
                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gray-900 text-sm font-semibold text-white">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>

                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold text-gray-900">{{ auth()->user()->name }}</p>
                    <p class="truncate text-xs text-gray-500">{{ auth()->user()->email }}</p>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-600 transition hover:bg-gray-100 hover:text-gray-900">
                    <i class="bi bi-box-arrow-right w-5 text-center text-base"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>