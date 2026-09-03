<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Give Space</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    @stack('styles')
</head>

<body class="bg-gray-50 text-gray-900">

    @include('components.dashboard.toast')

    <div class="min-h-screen">
        @include('components.dashboard.sidebar')


        <div class="lg:pl-64">
            @include('components.dashboard.topbar')

            <main class="px-6 py-6 lg:px-8">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')


</body>

</html>