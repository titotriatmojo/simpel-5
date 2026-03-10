<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIMPEL-5 - Sistem Informasi PKL') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/png" href="{{ asset('favicon-n5.png') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-white antialiased">
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-slate-900 via-primary-n5 to-secondary-n5 animate-[gradient_15s_ease_infinite] bg-[length:400%_400%]">
        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 rounded-xl shadow-xl bg-white border border-white/30">
            {{ $slot }}
        </div>
        <!-- Version Info -->
        <div class="text-center mt-6 mb-6">
            <p class="text-white text-xs drop-shadow-sm">
                SIMPEL-5 v1.0 &mdash; Crafted with Laravel & Tailwind CSS &copy; {{ date('Y') }}
            </p>
        </div>
    </div>
</body>


</html>