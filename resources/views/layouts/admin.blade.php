<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Admin Dashboard</title>

        <!-- Fonts: Plus Jakarta Sans & Figtree -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800|figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#f4f5f6] text-[#1a1d1f]" x-data="{ sidebarOpen: false }">
        <div class="min-h-screen flex">

            <!-- Desktop Sidebar -->
            <div class="hidden md:flex md:flex-shrink-0">
                <div class="sticky top-0 h-screen">
                    @include('layouts.sidebar')
                </div>
            </div>

            <!-- Mobile Off-Canvas Sidebar Backdrop -->
            <div x-show="sidebarOpen"
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-slate-950/60 backdrop-blur-xs z-40 md:hidden"
                 @click="sidebarOpen = false"
                 style="display: none;"></div>

            <!-- Mobile Off-Canvas Sidebar -->
            <div x-show="sidebarOpen"
                 x-transition:enter="transition ease-in-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-300 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="fixed inset-y-0 left-0 z-50 flex md:hidden"
                 style="display: none;">
                @include('layouts.sidebar')
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">

                <!-- Mobile Only Hamburger (Hidden on Desktop) -->
                <div class="md:hidden flex items-center justify-between p-4 bg-[#f4f5f6] sticky top-0 z-30">
                    <button @click="sidebarOpen = !sidebarOpen"
                            class="p-2.5 rounded-2xl bg-white border border-slate-200/60 text-slate-700 shadow-2xs focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <span class="font-extrabold text-sm text-[#1a1d1f]">Karsapedia Admin</span>
                    <div class="w-9 h-9 rounded-full bg-[#1a1d1f] text-white flex items-center justify-center font-bold text-xs">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>

                <!-- Main Content Slot -->
                <main class="flex-1 px-6 sm:px-10 pt-6 sm:pt-10 pb-12">
                    {{ $slot }}
                </main>
            </div>

        </div>
    </body>
</html>
