<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Karsapedia - Platform Layanan & Monitoring</title>

        <!-- Fonts: Plus Jakarta Sans & Figtree -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800|figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-white text-[#1a1d1f] min-h-screen flex flex-col justify-between relative overflow-x-hidden selection:bg-indigo-600 selection:text-white">

        <!-- Floating Decorative Vector Accents -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden -z-10">
            <!-- Left Top Blue Triangle -->
            <svg class="absolute top-36 left-[8%] w-6 h-6 text-indigo-400/80 -rotate-12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <polygon points="12 3 22 21 2 21" stroke-linejoin="round"/>
            </svg>

            <!-- Left Middle Sparkle -->
            <svg class="absolute top-[480px] left-[6%] w-7 h-7 text-rose-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 2v20M2 12h20M5 5l14 14M5 19L19 5"/>
            </svg>

            <!-- Right Top Green Circle -->
            <div class="absolute top-36 right-[12%] w-7 h-7 rounded-full border-[3px] border-emerald-500"></div>

            <!-- Right Middle Purple Semi Shape -->
            <div class="absolute top-[460px] right-[8%] w-4 h-4 bg-indigo-500 rounded-tr-xl"></div>
        </div>

        <!-- 1. Top Navbar -->
        <header class="sticky top-0 z-50 bg-white/85 backdrop-blur-md border-b border-slate-100">
            <div class="w-full max-w-7xl mx-auto px-6 lg:px-12 py-5">
                <nav class="flex items-center justify-between">
                    
                    <!-- Left: Logo & Brand -->
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-2xl bg-[#1a1d1f] flex items-center justify-center text-white shadow-xs">
                            <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 3v18M3 12h18"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-[#1a1d1f] tracking-tight">Karsapedia</span>
                    </a>

                    <!-- Center: Navigation Links -->
                    <div class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-600">
                        <a href="#fitur" class="hover:text-black transition">Fitur</a>
                        <a href="#layanan" class="hover:text-black transition">Layanan</a>
                        <a href="#tentang" class="hover:text-black transition">Tentang</a>
                        <a href="#kontak" class="hover:text-black transition">Kontak</a>
                    </div>

                    <!-- Right: Actions -->
                    <div class="flex items-center gap-3 sm:gap-4">
                        @auth
                            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : url('/dashboard') }}"
                               class="px-5 py-2.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-500/20 transition">
                                Dashboard
                            </a>
                        @else
                            <a href="#unduh"
                               class="hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-2xl border border-slate-200/90 text-xs font-bold text-slate-700 hover:bg-slate-50 transition shadow-2xs">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <rect x="5" y="2" width="14" height="20" rx="3"/>
                                    <path d="M12 18h.01"/>
                                </svg>
                                <span>Unduh Aplikasi</span>
                            </a>

                            <span class="hidden sm:inline-block w-px h-5 bg-slate-200"></span>

                            <a href="{{ route('login') }}"
                               class="px-3 py-2 text-xs font-bold text-slate-700 hover:text-black transition">
                                Masuk
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="px-5 py-2.5 rounded-2xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold shadow-md shadow-indigo-500/25 transition">
                                    Daftar
                                </a>
                            @endif
                        @endauth
                    </div>

                </nav>
            </div>
        </header>

        <!-- 2. Hero Section -->
        <section class="w-full max-w-4xl mx-auto px-6 pt-16 pb-20 sm:pt-24 sm:pb-28 flex flex-col items-center justify-center text-center">

            <!-- Giant Bold Headline with Underline Squiggle -->
            <h1 class="text-4xl sm:text-6xl lg:text-[64px] font-bold text-[#1a1d1f] tracking-tight leading-[1.18]">
                Kelola Seluruh Kebutuhan<br>
                <span class="relative inline-block mt-1">
                    <span>Karsapedia</span>
                    <svg class="absolute -bottom-2 sm:-bottom-3 left-0 w-full h-3 sm:h-4 text-indigo-500 pointer-events-none" viewBox="0 0 240 16" fill="none" preserveAspectRatio="none">
                        <path d="M4 12c50-8 150-10 232 2" stroke="currentColor" stroke-width="4.5" stroke-linecap="round"/>
                    </svg>
                </span>
            </h1>

            <!-- Subtitle Description (Lorem Ipsum) -->
            <p class="max-w-xl mx-auto text-sm sm:text-base text-slate-500 mt-6 sm:mt-8 leading-relaxed font-normal">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. We have it all!
            </p>

            <!-- Feature Pills Row -->
            <div class="mt-8 sm:mt-10 flex flex-wrap items-center justify-center gap-2.5 sm:gap-3.5">
                
                <!-- Pill 1: Green -->
                <div class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-slate-50/90 border border-slate-100 shadow-2xs">
                    <span class="w-4 h-4 rounded-full bg-emerald-500 text-white flex items-center justify-center flex-shrink-0">
                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </span>
                    <span class="text-xs font-bold text-slate-700">Lorem Ipsum</span>
                </div>

                <!-- Pill 2: Blue -->
                <div class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-slate-50/90 border border-slate-100 shadow-2xs">
                    <span class="w-4 h-4 rounded-full bg-sky-500 text-white flex items-center justify-center flex-shrink-0">
                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </span>
                    <span class="text-xs font-bold text-slate-700">Dolor Sit Amet</span>
                </div>

                <!-- Pill 3: Orange -->
                <div class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl bg-slate-50/90 border border-slate-100 shadow-2xs">
                    <span class="w-4 h-4 rounded-full bg-amber-500 text-white flex items-center justify-center flex-shrink-0">
                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </span>
                    <span class="text-xs font-bold text-slate-700">Consectetur Adipiscing</span>
                </div>

                <!-- Pill 4: Accent Badge -->
                <div class="inline-flex items-center justify-center w-8 h-8 rounded-2xl bg-rose-500 text-white text-xs font-bold shadow-xs">
                    6+
                </div>

            </div>

        </section>

        <!-- 3. Section Fitur (#fitur) -->
        <section id="fitur" class="w-full bg-[#f8f9fa] py-20 border-y border-slate-100">
            <div class="max-w-7xl mx-auto px-6 lg:px-12 space-y-12">
                
                <!-- Section Header -->
                <div class="text-center max-w-2xl mx-auto space-y-3">
                    <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest">Fitur Karsapedia</span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-[#1a1d1f] tracking-tight">
                        Fitur Unggulan Sistem
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                </div>

                <!-- Bento Cards Grid 3 Kolom -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <!-- Card Fitur 1 -->
                    <div class="bg-white rounded-[28px] p-8 shadow-2xs border border-slate-200/60 space-y-4 hover:shadow-sm transition">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <rect x="3" y="3" width="7" height="7" rx="2"/>
                                <rect x="14" y="3" width="7" height="7" rx="2"/>
                                <rect x="14" y="14" width="7" height="7" rx="2"/>
                                <rect x="3" y="14" width="7" height="7" rx="2"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#1a1d1f]">Fitur Pertama</h3>
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore.
                        </p>
                    </div>

                    <!-- Card Fitur 2 -->
                    <div class="bg-white rounded-[28px] p-8 shadow-2xs border border-slate-200/60 space-y-4 hover:shadow-sm transition">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#1a1d1f]">Fitur Kedua</h3>
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                            Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat duis aute irure.
                        </p>
                    </div>

                    <!-- Card Fitur 3 -->
                    <div class="bg-white rounded-[28px] p-8 shadow-2xs border border-slate-200/60 space-y-4 hover:shadow-sm transition">
                        <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-[#1a1d1f]">Fitur Ketiga</h3>
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum sed ut perspiciatis.
                        </p>
                    </div>

                </div>

            </div>
        </section>

        <!-- 4. Section Layanan (#layanan) -->
        <section id="layanan" class="w-full py-20">
            <div class="max-w-7xl mx-auto px-6 lg:px-12 space-y-12">
                
                <!-- Section Header -->
                <div class="text-center max-w-2xl mx-auto space-y-3">
                    <span class="text-xs font-bold text-emerald-600 uppercase tracking-widest">Layanan Terintegrasi</span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-[#1a1d1f] tracking-tight">
                        Layanan Pengguna Karsapedia
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                </div>

                <!-- 2-Row / Bento Grid Layanan -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Layanan 1: Siswa -->
                    <div class="bg-slate-50 rounded-[32px] p-8 sm:p-10 border border-slate-100 flex flex-col justify-between space-y-6">
                        <div class="space-y-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-sky-100 text-sky-700">
                                Layanan Siswa
                            </span>
                            <h3 class="text-2xl font-bold text-[#1a1d1f]">Layanan Pembelajaran Siswa</h3>
                            <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
                            </p>
                        </div>
                        <div class="pt-4 border-t border-slate-200/60 flex items-center text-xs font-bold text-sky-700">
                            <span>Pelajari Selengkapnya</span>
                            <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>

                    <!-- Layanan 2: Guru -->
                    <div class="bg-slate-50 rounded-[32px] p-8 sm:p-10 border border-slate-100 flex flex-col justify-between space-y-6">
                        <div class="space-y-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                Layanan Guru
                            </span>
                            <h3 class="text-2xl font-bold text-[#1a1d1f]">Layanan Pendidik & Kurator</h3>
                            <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                                Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur excepteur sint occaecat cupidatat non proident.
                            </p>
                        </div>
                        <div class="pt-4 border-t border-slate-200/60 flex items-center text-xs font-bold text-emerald-700">
                            <span>Pelajari Selengkapnya</span>
                            <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <!-- 5. Section Tentang (#tentang) -->
        <section id="tentang" class="w-full bg-[#f8f9fa] py-20 border-t border-slate-100">
            <div class="max-w-7xl mx-auto px-6 lg:px-12">
                <div class="bg-white rounded-[32px] p-8 sm:p-14 shadow-2xs border border-slate-200/60 flex flex-col lg:flex-row items-center justify-between gap-10">
                    
                    <!-- Left: Deskripsi Tentang -->
                    <div class="max-w-xl space-y-4">
                        <span class="text-xs font-bold text-indigo-600 uppercase tracking-widest">Tentang Karsapedia</span>
                        <h2 class="text-3xl sm:text-4xl font-bold text-[#1a1d1f] tracking-tight">
                            Mengenal Lebih Dekat Platform Karsapedia
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam. Sed nisi. Nulla quis sem at nibh elementum imperdiet.
                        </p>
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                            Duis sagittis ipsum. Praesent mauris. Fusce nec tellus sed augue semper porta. Mauris massa. Vestibulum lacinia arcu eget nulla.
                        </p>
                    </div>

                    <!-- Right: Highlight Metrics Box (Clean & Formal) -->
                    <div class="w-full lg:w-80 grid grid-cols-2 gap-4 flex-shrink-0">
                        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 text-center space-y-1">
                            <span class="text-3xl font-bold text-[#1a1d1f]">100%</span>
                            <p class="text-xs font-semibold text-slate-400">Lorem Ipsum</p>
                        </div>
                        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 text-center space-y-1">
                            <span class="text-3xl font-bold text-[#1a1d1f]">24/7</span>
                            <p class="text-xs font-semibold text-slate-400">Dolor Amet</p>
                        </div>
                        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 text-center space-y-1">
                            <span class="text-3xl font-bold text-[#1a1d1f]">Core</span>
                            <p class="text-xs font-semibold text-slate-400">Consectetur</p>
                        </div>
                        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100 text-center space-y-1">
                            <span class="text-3xl font-bold text-[#1a1d1f]">Fast</span>
                            <p class="text-xs font-semibold text-slate-400">Adipiscing</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- 6. Section Kontak (#kontak) -->
        <section id="kontak" class="w-full py-20">
            <div class="max-w-4xl mx-auto px-6 text-center space-y-8">
                
                <div class="space-y-3">
                    <span class="text-xs font-bold text-rose-600 uppercase tracking-widest">Hubungi Kami</span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-[#1a1d1f] tracking-tight">
                        Punya Pertanyaan Seputar Karsapedia?
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 max-w-lg mx-auto leading-relaxed">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                </div>

                <!-- Kontak Card Minimalis -->
                <div class="bg-white rounded-[32px] p-8 sm:p-10 shadow-2xs border border-slate-200/60 max-w-xl mx-auto space-y-6">
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 text-xs font-bold text-slate-600">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>kontak@karsapedia.test</span>
                        </div>
                        <span class="hidden sm:inline text-slate-300">•</span>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>+62 812-3456-7890</span>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="pt-4 flex flex-wrap items-center justify-center gap-3">
                        <a href="{{ route('login') }}"
                           class="px-6 py-2.5 rounded-full bg-[#1a1d1f] hover:bg-black text-white text-xs font-bold shadow-sm transition">
                            Masuk ke Akun
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="px-6 py-2.5 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition">
                                Daftar Pengguna Baru
                            </a>
                        @endif
                    </div>
                </div>

            </div>
        </section>

        <!-- 7. Footer -->
        <footer class="w-full border-t border-slate-100 bg-[#f8f9fa] py-8">
            <div class="max-w-7xl mx-auto px-6 lg:px-12 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-400">
                <div class="flex items-center gap-2">
                    <span class="font-bold text-[#1a1d1f]">Karsapedia</span>
                    <span>&copy; {{ date('Y') }}. Seluruh hak cipta dilindungi.</span>
                </div>
                <div class="flex items-center gap-6 font-medium">
                    <a href="#fitur" class="hover:text-slate-700 transition">Fitur</a>
                    <a href="#layanan" class="hover:text-slate-700 transition">Layanan</a>
                    <a href="#tentang" class="hover:text-slate-700 transition">Tentang</a>
                    <a href="#kontak" class="hover:text-slate-700 transition">Kontak</a>
                </div>
            </div>
        </footer>

    </body>
</html>
