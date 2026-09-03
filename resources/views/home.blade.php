<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Give Space - Berbagi Kebaikan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-white text-gray-900">
    <main class="relative flex min-h-screen items-center justify-center overflow-hidden px-6 py-12">
        <div class="absolute left-1/2 top-0 h-96 w-96 -translate-x-1/2 rounded-full bg-indigo-50 blur-3xl"></div>
        <div class="absolute -bottom-20 -left-20 h-64 w-64 rounded-full bg-gray-100 blur-3xl"></div>
        <div class="absolute -right-20 top-1/3 h-64 w-64 rounded-full bg-indigo-50 blur-3xl"></div>

        <div class="relative w-full max-w-3xl text-center">
            {{-- <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight text-gray-900">Give Space</a> --}}

            <div class="mx-auto mt-16 max-w-2xl">
                {{-- <span
                    class="inline-flex items-center rounded-full border border-indigo-100 bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-600">
                    Berbagi kebaikan, mulai dari sekarang.
                </span> --}}

                <h1 class="mt-6 text-4xl font-semibold tracking-tight text-gray-900 sm:text-5xl lg:text-6xl">
                    Satu langkah kecil,<br class="hidden sm:block"> berarti bagi mereka.
                </h1>

                <p class="mx-auto mt-6 max-w-xl text-base leading-7 text-gray-500 sm:text-lg">
                    Give Space membantu kamu menyalurkan donasi kepada campaign yang membutuhkan dengan cara yang
                    sederhana dan transparan.
                </p>

                <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
                    <a href="{{ route('user.campaigns.index') }}"
                        class="w-full rounded-lg bg-gray-900 px-6 py-3 text-sm font-medium text-white shadow-sm hover:bg-gray-800 sm:w-auto">
                        Lihat Campaign
                    </a>
                    <a href="{{ route('login') }}"
                        class="w-full rounded-lg border border-gray-200 bg-white px-6 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 sm:w-auto">
                        Masuk
                    </a>
                </div>

                <p class="mt-6 text-sm text-gray-400">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-medium text-gray-600 hover:text-gray-900">Daftar
                        sekarang</a>
                </p>
            </div>

            {{-- <div class="mx-auto mt-16 flex max-w-md items-center justify-center gap-2 text-xs text-gray-400">
                <span class="h-1.5 w-1.5 rounded-full bg-indigo-400"></span>
                Transparan
                <span class="mx-2 text-gray-200">•</span>
                Mudah
                <span class="mx-2 text-gray-200">•</span>
                Bersama
            </div> --}}
        </div>
    </main>
</body>

</html>