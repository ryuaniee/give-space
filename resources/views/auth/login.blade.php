<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Give Space</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>
    <div class="flex min-h-screen items-center justify-center">
        <div class="flex w-full max-w-sm flex-col justify-center px-6 py-12">
            <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                {{-- <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600"
                    alt="Give Space" class="mx-auto h-10 w-auto"> --}}
                <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Sign in to your account
                </h2>
            </div>
            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                @if (session('success'))
                    <div class="mb-6 rounded-lg bg-green-100 p-4 text-sm text-green-700">{{ session('success') }}</div>
                @endif
                <form action="{{ route('login.process') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm/6 font-medium text-gray-900">Email address</label>
                        <div class="mt-2">
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                autocomplete="email" placeholder="example@email.com"
                                class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-bg-gray-900 sm:text-sm/6">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
                            {{-- <a href="#" class="text-sm font-semibold text-bg-gray-900 hover:text-indigo-500">Forgot
                                password?</a> --}}
                        </div>
                        <div class="mt-2">
                            <input id="password" type="password" name="password" required
                                autocomplete="current-password" placeholder="••••••••"
                                class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-bg-gray-900 sm:text-sm/6">
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <button type="submit"
                            class="flex w-full justify-center rounded-md bg-gray-900 px-3 py-2 text-sm/6 font-semibold text-white shadow-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-bg-gray-900">Sign
                            in</button>
                    </div>
                </form>
                <p class="mt-10 text-center text-sm/6 text-gray-500">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="font-semibold text-gray-600 hover:text-gray-900">Create
                        an account</a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>