<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - Give Space</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-50 text-gray-900">
    <main class="relative flex min-h-screen items-center justify-center overflow-hidden px-6 py-12">
        <div class="absolute -left-24 -top-24 h-72 w-72 rounded-full bg-indigo-100 opacity-60 blur-3xl"></div>
        <div class="absolute -bottom-24 -right-24 h-72 w-72 rounded-full bg-indigo-100 opacity-60 blur-3xl"></div>

        <div class="relative w-full max-w-lg">
            <div class="rounded-2xl border border-gray-200 bg-white p-8 text-center shadow-sm sm:p-10">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-green-50 text-green-600">
                    <i class="bi bi-check-lg text-2xl"></i>
                </div>

                <p class="mt-6 text-sm font-medium text-indigo-600">Donasi berhasil dikirim</p>
                <h1 class="mt-2 text-3xl font-semibold tracking-tight text-gray-900">Terima kasih telah berbagi.</h1>
                <p class="mx-auto mt-4 max-w-md text-sm leading-6 text-gray-500">
                    Donasi kamu sudah kami terima dan sedang menunggu verifikasi dari Admin Give Space.
                </p>

                <div class="mt-8 rounded-xl bg-gray-50 p-5 text-left">
                    <div class="flex items-center justify-between border-b border-gray-200 pb-4">
                        <div>
                            <p class="text-xs text-gray-500">Kode Transaksi</p>
                            <p class="mt-1 text-sm font-semibold text-gray-900">{{ $transaction->transaction_code }}</p>
                        </div>
                        <span
                            class="rounded-full bg-yellow-50 px-2.5 py-1 text-xs font-medium text-yellow-700">Pending</span>
                    </div>

                    <div class="mt-4">
                        <p class="text-xs text-gray-500">Campaign</p>
                        <p class="mt-1 text-sm font-medium text-gray-900">{{ $transaction->campaign->title }}</p>
                    </div>

                    <div class="mt-4">
                        <p class="text-xs text-gray-500">Nominal Donasi</p>
                        <p class="mt-1 text-lg font-semibold text-gray-900">Rp
                            {{ number_format($transaction->amount, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-center">
                    <a href="{{ route('user.transactions.show', $transaction) }}"
                        class="rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-800">
                        Lihat Status Donasi
                    </a>
                    <a href="{{ route('user.dashboard') }}"
                        class="rounded-lg border border-gray-200 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Kembali ke Dashboard
                    </a>
                </div>

                <p class="mt-6 text-xs text-gray-400">
                    Simpan kode transaksi kamu untuk melihat status donasi.
                </p>
            </div>

        </div>
    </main>
</body>

</html>