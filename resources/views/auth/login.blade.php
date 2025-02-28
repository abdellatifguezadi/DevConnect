<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-50">
        <div class="w-full max-w-md p-8 bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl space-y-6">
            <div class="text-center">
                <h2 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                    Bienvenue
                </h2>
                <p class="mt-2 text-gray-600">Connectez-vous à votre compte</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input id="password" class="block mt-1 w-full"
                        type="password"
                        name="password"
                        required autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between mt-6">
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-gray-700">Se souvenir de moi</span>
                    </label>

                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-500">
                        Mot de passe oublié?
                    </a>
                    @endif
                </div>

                <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:opacity-90 transition duration-200">
                    Se connecter
                </button>
            </form>

            <p class="text-center text-sm text-gray-600">
                Pas encore de compte?
                <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Inscrivez-vous
                </a>
            </p>
        </div>
    </div>
</body>

</html>