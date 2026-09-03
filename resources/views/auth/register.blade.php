<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Give Space</title>
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
                <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Create your account</h2>
            </div>
            <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                <form action="{{ route('register.process') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm/6 font-medium text-gray-900">Full Name</label>
                        <div class="mt-2">
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                                autocomplete="name" placeholder="Your name"
                                class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-bg-gray-900 sm:text-sm/6">
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm/6 font-medium text-gray-900">Email address</label>
                        <div class="mt-2">
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                autocomplete="email" placeholder="example@email.com"
                                class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-bg-gray-900 sm:text-sm/6">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
                        <div class="mt-2">
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                placeholder="Minimum 8 characters"
                                class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-bg-gray-900 sm:text-sm/6">
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm/6 font-medium text-gray-900">Confirm
                            Password</label>
                        <div class="mt-2">
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                autocomplete="new-password" placeholder="Repeat your password"
                                class="block w-full rounded-md bg-white px-3 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-bg-gray-900 sm:text-sm/6">
                        </div>
                    </div>
                    <div>
                        <button type="submit"
                            class="flex w-full justify-center rounded-md bg-gray-900 px-3 py-2 text-sm/6 font-semibold text-white shadow-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-bg-gray-900">Create
                            Account</button>
                    </div>
                </form>
                <p class="mt-10 text-center text-sm/6 text-gray-500">
                    Already have an account?
                    <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900">Sign
                        in</a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>