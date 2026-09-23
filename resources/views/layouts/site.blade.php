<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? config('app.name') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>
    <body class="font-family-body bg-bg-main text-text-primary selection:bg-accent-base selection:text-bg-main antialiased overflow-x-hidden">

        <!-- ==================== HEADER & NAVIGÁCIÓ ==================== -->
        <header
            x-data="{
                mobileMenuOpen: false,
                menuItems: [
                    { content: 'Főoldal', link: '#fooldal' },
                    { content: 'Nyári gumi', link: '#nyar-igumi' },
                    { content: 'Téli gumi', link: '#teli-gumi' },
                    { content: 'Négyévszakos', link: '#negyevszakos' },
                    { content: 'Alufelni', link: '#alufelni' },
                    { content: 'Szerviz', link: '#szerviz' },
                ],
            }"
            class="bg-slate-900 text-white sticky top-0 z-50 shadow-lg"
        >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16 sm:h-20">

                    <!-- Logo (Kompaktabb mobilon) -->
                    <a href="#" class="flex items-center gap-2">
                        <div class="bg-red-600 p-1.5 sm:p-2 rounded-xl text-white shadow-md">
                            <svg class="w-5 h-5 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="9" stroke-width="2"></circle>
                                <circle cx="12" cy="12" r="3" stroke-width="2"></circle>
                                <path stroke-linecap="round" stroke-width="2" d="M12 3v6m0 6v6m9-9h-6m-6 0H3"></path>
                            </svg>
                        </div>
                        <span class="text-xl sm:text-2xl font-black tracking-wider uppercase">Gumi<span class="text-red-500">Pro</span></span>
                    </a>

                    <!-- Desktop Navigációs Menü -->
                    <nav class="hidden lg:flex space-x-8 text-sm font-bold uppercase tracking-wider">
                        <template x-for="menuItem in menuItems">
                            <a :href="menuItem.link" class="hover:text-red-500 transition-colors" x-text="menuItem.content"></a>
                        </template>
                        
                    </nav>

                    <!-- Jobb oldali akciók & Hamburger ikon mobilon -->
                    <div class="flex items-center gap-2 sm:gap-4">

                        <!-- Fiók ikon -->
                        <a href="{{ route('login') }}" class="p-2 text-slate-300 hover:text-white transition-colors flex items-center gap-1.5 text-xs font-bold uppercase" aria-label="Fiók">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            @if (Auth::check())
                                <span class="hidden md:inline">{{ Auth::user()->name }}</span>
                            @else
                                <span class="hidden md:inline">Fiók</span>
                            @endif
                        </a>

                        <!-- Kosár gomb -->
                        <livewire:cart-count />

                        <!-- Hamburger gomb (Kifejezetten kis méretűre szabva mobilon) -->
                        <button @click="mobileMenuOpen = !mobileMenuOpen"
                                type="button"
                                class="lg:hidden p-2 text-slate-300 hover:text-white hover:bg-slate-800 rounded-xl transition-colors border border-slate-700 focus:outline-none"
                                aria-label="Menü megnyitása">
                            <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                            <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobil Menü Lenyíló (Görgethető, kis kijelzőkre optimalizálva) -->
            <div x-show="mobileMenuOpen"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="lg:hidden bg-slate-900 border-b border-slate-800 px-4 pt-3 pb-6 space-y-1.5 font-bold uppercase text-xs tracking-wider max-h-[calc(100vh-4rem)] overflow-y-auto"
                 style="display: none;">

                <template x-for="menuItem in menuItems">
                    <a :href="menuItem.link" @click="mobileMenuOpen = false" class="block py-3 px-3 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition-colors" x-text="menuItem.content"></a>
                </template>
                
            </div>
        </header>

        {{ $slot }}

        <footer class="bg-slate-900 text-slate-400 text-xs border-t-4 border-red-600">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 grid grid-cols-1 md:grid-cols-4 gap-10">

                <div class="space-y-4">
                    <span class="text-2xl font-black uppercase text-white">Gumi<span class="text-red-500">Pro</span></span>
                    <p class="leading-relaxed">Prémium minőségű gumiabroncsok és felnik kereskedelme, gyors kiszolgálással és szakszerű szerviz szolgáltatással.</p>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-4 uppercase tracking-wider text-sm">Vásárlás</h4>
                    <ul class="space-y-2.5">
                        <li><a href="#" class="hover:text-red-500 transition-colors">Nyári gumiabroncsok</a></li>
                        <li><a href="#" class="hover:text-red-500 transition-colors">Téli gumiabroncsok</a></li>
                        <li><a href="#" class="hover:text-red-500 transition-colors">Négyévszakos abroncsok</a></li>
                        <li><a href="#" class="hover:text-red-500 transition-colors">Alufelni választék</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-4 uppercase tracking-wider text-sm">Információk</h4>
                    <ul class="space-y-2.5">
                        <li><a href="#" class="hover:text-red-500 transition-colors">Fizetés és Szállítás</a></li>
                        <li><a href="#" class="hover:text-red-500 transition-colors">Garanciális feltételek</a></li>
                        <li><a href="#" class="hover:text-red-500 transition-colors">Általános Szerződési Feltételek</a></li>
                        <li><a href="#" class="hover:text-red-500 transition-colors">Adatkezelési Tájékoztató</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-4 uppercase tracking-wider text-sm">Ügyfélszolgálat</h4>
                    <p class="mb-2"><strong>Tel:</strong> +36 1 234 5678</p>
                    <p class="mb-2"><strong>Email:</strong> info@gumipro.hu</p>
                    <p><strong>Cím:</strong> 1000 Budapest, Gumi utca 12.</p>
                </div>

            </div>

            <div class="bg-slate-950 py-6 border-t border-slate-800 text-center text-slate-500">
                <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p>&copy; 2026 GumiPro Webshop Demo - Minden jog fenntartva.</p>
                    <div class="flex gap-4 font-bold">
                        <span class="hover:text-white cursor-pointer">VISA</span>
                        <span class="hover:text-white cursor-pointer">MasterCard</span>
                        <span class="hover:text-white cursor-pointer">UTÁNVÉT</span>
                    </div>
                </div>
            </div>
        </footer>

        @livewireScripts
    </body>
</html>
