<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ auth()->user()->id ?? '' }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Toastr & Font Awesome for notifications -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- <style>
        [x-cloak] { display: none !important; }
        
        /* Notification Styles */
        .toast-info .toast-message {
            display: flex;
            align-items: center;
        }

        .toast-info .toast-message i {
            margin-right: 10px;
        }

        .toast-info .toast-message .notification-content {
            display: flex;
            flex-direction: row;
            align-items: center;
        }
    </style> -->
    
    @vite('resources/css/app.css')
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Affichage des erreurs de validation -->
        <x-validation-errors />
        
        <!-- Affichage des messages de succès -->
        @if(session('success'))
        <div class="fixed top-20 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg"
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 3000)">
            {{ session('success') }}
        </div>
        @endif

        <!-- Affichage des messages d'erreur -->
        @if(session('error'))
        <div class="fixed top-20 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg"
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => show = false, 3000)">
            {{ session('error') }}
        </div>
        @endif

        <!-- Page Heading -->
        @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <!-- jQuery, Toastr & Pusher Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    
    <!-- Define Pusher configuration for the JS file -->
    <script>
        var PUSHER_APP_KEY = '{{ env('PUSHER_APP_KEY') }}';
        var PUSHER_APP_CLUSTER = '{{ env('PUSHER_APP_CLUSTER') }}';
    </script>
    
    <!-- Ajout de l'attribut defer et vérification que le fichier existe -->
    @if(file_exists(public_path('js/social-interactions.js')))
    <script src="{{ asset('js/social-interactions.js') }}" defer></script>
    @endif

    @if(file_exists(public_path('js/infinite-scroll.js')))
    <script src="{{ asset('js/infinite-scroll.js') }}" defer></script>
    @endif

    @if(file_exists(public_path('js/post-media-preview.js')))
    <script src="{{ asset('js/post-media-preview.js') }}" defer></script>
    @endif
    
    <!-- Pusher Notifications -->
    <script src="{{ asset('js/pusher-notifications.js') }}" defer></script>
    
    @stack('scripts')
</body>

</html>