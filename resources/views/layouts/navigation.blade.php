<nav x-data="{ open: false }" class="bg-white border-b border-slate-200/60 sticky top-0 z-40">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-6 sm:px-10">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-8">
                <!-- Brand Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                        <div class="w-9 h-9 rounded-2xl bg-[#1a1d1f] flex items-center justify-center text-white shadow-xs group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 3v18M3 12h18"/>
                            </svg>
                        </div>
                        <span class="text-lg font-bold text-[#1a1d1f] tracking-tight">Karsapedia</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex items-center gap-3">
                    <a href="{{ route('dashboard') }}"
                       class="px-4 py-2 rounded-xl text-xs font-bold transition {{ request()->routeIs('dashboard') ? 'bg-[#f4f5f6] text-[#1a1d1f]' : 'text-slate-500 hover:text-black hover:bg-slate-50' }}">
                        Dashboard
                    </a>

                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}"
                           class="px-4 py-2 rounded-xl text-xs font-bold transition text-indigo-700 bg-indigo-50 hover:bg-indigo-100">
                            Panel Monitoring Admin
                        </a>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2.5 px-3 py-2 border border-slate-200/80 rounded-2xl text-xs font-bold text-slate-700 bg-white hover:bg-slate-50 shadow-2xs transition">
                            <div class="w-6 h-6 rounded-full bg-[#1a1d1f] text-white flex items-center justify-center text-[10px] uppercase font-bold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span>{{ Auth::user()->name }}</span>
                            <span class="text-[10px] font-semibold text-slate-400 capitalize">({{ Auth::user()->role }})</span>
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Pengaturan Profil
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                Keluar
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-500 hover:text-slate-800 hover:bg-slate-100 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-slate-100 bg-white px-6 py-4 space-y-3">
        <div class="space-y-1">
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-xl text-xs font-bold {{ request()->routeIs('dashboard') ? 'bg-[#f4f5f6] text-[#1a1d1f]' : 'text-slate-600' }}">
                Dashboard
            </a>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-xl text-xs font-bold text-indigo-700 bg-indigo-50">
                    Panel Monitoring Admin
                </a>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-3 border-t border-slate-100">
            <div class="text-xs font-bold text-[#1a1d1f]">{{ Auth::user()->name }}</div>
            <div class="text-[11px] text-slate-400 font-medium">{{ Auth::user()->email }} ({{ ucfirst(Auth::user()->role) }})</div>

            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}" class="block text-xs font-semibold text-slate-600 hover:text-black py-1">
                    Pengaturan Profil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left text-xs font-semibold text-rose-600 hover:text-rose-700 py-1">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
