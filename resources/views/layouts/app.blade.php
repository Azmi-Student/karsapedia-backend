<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Karsapedia') }}</title>

        <!-- Fonts: Plus Jakarta Sans & Figtree -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800|figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#f4f5f6] text-[#1a1d1f] min-h-screen flex flex-col justify-between selection:bg-[#1a1d1f] selection:text-white">
        <div class="flex-1 flex flex-col">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white border-b border-slate-200/60 py-6 px-6 sm:px-10">
                    <div class="max-w-7xl mx-auto">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1 py-8 px-6 sm:px-10 max-w-7xl mx-auto w-full">
                {{ $slot }}
            </main>
        </div>

        <footer class="py-6 text-center text-xs text-slate-400 border-t border-slate-200/60">
            <p>&copy; {{ date('Y') }} Karsapedia. Seluruh hak cipta dilindungi.</p>
        </footer>
    </body>
</html>
