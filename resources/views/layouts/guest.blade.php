<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Karsapedia') }} - Akses Akun</title>

        <!-- Fonts: Plus Jakarta Sans & Figtree -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800|figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#f4f5f6] text-[#1a1d1f] min-h-screen flex flex-col justify-between p-4 sm:p-8 selection:bg-[#1a1d1f] selection:text-white">

        <!-- Top Header: Logo on Left, Kembali on Right -->
        <header class="w-full max-w-4xl mx-auto flex items-center justify-between py-2">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-[#1a1d1f] flex items-center justify-center text-white shadow-xs">
                    <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M12 3v18M3 12h18"/>
                    </svg>
                </div>
                <span class="text-base font-bold text-[#1a1d1f] tracking-tight">Karsapedia</span>
            </a>

            <!-- Tombol Kembali ke Beranda -->
            <a href="{{ url('/') }}"
               class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-white border border-slate-200 text-xs font-semibold text-slate-600 hover:text-black shadow-2xs hover:bg-slate-50 transition">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Kembali</span>
            </a>
        </header>

        <!-- Main Slot -->
        <main class="w-full max-w-4xl mx-auto my-auto py-4">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="w-full max-w-4xl mx-auto text-center text-xs text-slate-400 py-2">
            <p>&copy; {{ date('Y') }} Karsapedia. Seluruh hak cipta dilindungi.</p>
        </footer>

    </body>
</html>
