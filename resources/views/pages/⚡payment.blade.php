<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

new #[Layout('layouts::site'), Title('GumiPro - Szállítási és fizetési mód')] class extends Component
{
    //
};
?>

<!-- ==================== AUTÓGUMI WEBSHOP - SZÁLLÍTÁSI ÉS FIZETÉSI MÓD KIVÁLASZTÁSA ==================== -->
<section class="bg-gray-50 min-h-screen py-8 px-4 sm:px-6 lg:px-8 text-gray-800">
    <div class="max-w-4xl mx-auto space-y-8">
        
        <!-- Oldal Fejléc -->
        <div class="text-center">
            <span class="text-xs font-extrabold uppercase tracking-widest text-red-600 bg-red-50 px-3 py-1 rounded-full border border-red-100 inline-block mb-2">
                2. Lépés
            </span>
            <h1 class="text-2xl sm:text-3xl font-black text-gray-900 uppercase tracking-tight">Szállítás & Fizetés</h1>
            <p class="text-sm text-gray-500 mt-1 max-w-lg mx-auto">
                Válaszd ki a számodra legmegfelelőbb szállítási és fizetési módot.
            </p>
        </div>

        <form action="#" method="POST" class="space-y-8">
            
            <!-- 1. SZÁLLÍTÁSI MÓDOK -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8 space-y-6">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                    <h2 class="text-lg font-extrabold text-gray-900 flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-red-600"></span>
                        1. Szállítási Mód Kiválasztása
                    </h2>
                    <span class="text-xs font-semibold text-gray-400">4 db gumiabroncs a kosárban</span>
                </div>

                <div class="space-y-3">
                    
                    <!-- DPD Futár -->
                    <label class="relative flex items-center justify-between p-4 sm:p-5 rounded-xl border-2 border-red-600 bg-red-50/30 cursor-pointer transition-all hover:bg-gray-50">
                        <div class="flex items-center gap-4">
                            <input type="radio" name="shipping_method" value="dpd" checked class="w-5 h-5 text-red-600 border-gray-300 focus:ring-red-500">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-gray-900 text-sm sm:text-base">DPD Gumiabroncs Futárszolgálat</span>
                                    <span class="text-[10px] font-black bg-red-100 text-red-700 px-2 py-0.5 rounded uppercase">Ajánlott</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-0.5">Közvetlen házhozszállítás specifikus gumiabroncs csomagolásban (1-2 munkanap).</p>
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <span class="block text-sm sm:text-base font-extrabold text-gray-900">3.960 Ft</span>
                            <span class="text-[11px] text-gray-400">990 Ft / db</span>
                        </div>
                    </label>

                    <!-- GLS Futár -->
                    <label class="relative flex items-center justify-between p-4 sm:p-5 rounded-xl border border-gray-200 bg-white cursor-pointer transition-all hover:border-gray-300 hover:bg-gray-50">
                        <div class="flex items-center gap-4">
                            <input type="radio" name="shipping_method" value="gls" class="w-5 h-5 text-red-600 border-gray-300 focus:ring-red-500">
                            <div>
                                <span class="font-bold text-gray-900 text-sm sm:text-base">GLS Hungary Futárszolgálat</span>
                                <p class="text-xs text-gray-500 mt-0.5">Gyors és pontos házhozszállítás SMS és E-mail értesítéssel.</p>
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <span class="block text-sm sm:text-base font-extrabold text-gray-900">4.400 Ft</span>
                            <span class="text-[11px] text-gray-400">1.100 Ft / db</span>
                        </div>
                    </label>

                    <!-- Partner Gumiszerviz / Átszerelés -->
                    <label class="relative flex items-center justify-between p-4 sm:p-5 rounded-xl border border-gray-200 bg-white cursor-pointer transition-all hover:border-gray-300 hover:bg-gray-50">
                        <div class="flex items-center gap-4">
                            <input type="radio" name="shipping_method" value="service_point" class="w-5 h-5 text-red-600 border-gray-300 focus:ring-red-500">
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-gray-900 text-sm sm:text-base">Átvétel Partner Gumiszervizben</span>
                                    <span class="text-[10px] font-bold bg-green-100 text-green-700 px-2 py-0.5 rounded">Helyszíni szereléssel</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-0.5">A gumikat közvetlenül a választott gumis műhelybe szállítjuk, ahol fel is szerelik neked.</p>
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <span class="block text-sm sm:text-base font-extrabold text-green-600">INGYENES</span>
                            <span class="text-[11px] text-gray-400">Szállítás a szervizbe</span>
                        </div>
                    </label>

                    <!-- Személyes átvétel telephelyen -->
                    <label class="relative flex items-center justify-between p-4 sm:p-5 rounded-xl border border-gray-200 bg-white cursor-pointer transition-all hover:border-gray-300 hover:bg-gray-50">
                        <div class="flex items-center gap-4">
                            <input type="radio" name="shipping_method" value="pickup" class="w-5 h-5 text-red-600 border-gray-300 focus:ring-red-500">
                            <div>
                                <span class="font-bold text-gray-900 text-sm sm:text-base">Személyes átvétel központi raktárunkban</span>
                                <p class="text-xs text-gray-500 mt-0.5">3300 Eger, Kerecsendi út 10. (Azonnal átvehető, ha raktáron van)</p>
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <span class="block text-sm sm:text-base font-extrabold text-green-600">INGYENES</span>
                        </div>
                    </label>

                </div>
            </div>

            <!-- 2. FIZETÉSI MÓDOK -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8 space-y-6">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                    <h2 class="text-lg font-extrabold text-gray-900 flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-slate-900"></span>
                        2. Fizetési Mód Kiválasztása
                    </h2>
                </div>

                <div class="space-y-3">
                    
                    <!-- Bankkártyás fizetés -->
                    <label class="relative flex items-center justify-between p-4 sm:p-5 rounded-xl border-2 border-red-600 bg-red-50/30 cursor-pointer transition-all hover:bg-gray-50">
                        <div class="flex items-center gap-4">
                            <input type="radio" name="payment_method" value="card" checked class="w-5 h-5 text-red-600 border-gray-300 focus:ring-red-500">
                            <div>
                                <span class="font-bold text-gray-900 text-sm sm:text-base">Online bankkártyás fizetés (Barion / SimplePay)</span>
                                <p class="text-xs text-gray-500 mt-0.5">Biztonságos, azonnali fizetés bármilyen Visa, Mastercard vagy Maestro kártyával.</p>
                            </div>
                        </div>
                        <span class="text-xs font-bold text-green-600 bg-green-50 px-2.5 py-1 rounded-md border border-green-200">Díjmentes</span>
                    </label>

                    <!-- Utánvét -->
                    <label class="relative flex items-center justify-between p-4 sm:p-5 rounded-xl border border-gray-200 bg-white cursor-pointer transition-all hover:border-gray-300 hover:bg-gray-50">
                        <div class="flex items-center gap-4">
                            <input type="radio" name="payment_method" value="cod" class="w-5 h-5 text-red-600 border-gray-300 focus:ring-red-500">
                            <div>
                                <span class="font-bold text-gray-900 text-sm sm:text-base">Utánvét (Fizetés átvételkor a futárnál)</span>
                                <p class="text-xs text-gray-500 mt-0.5">Fizess készpénzzel vagy bankkártyával a futárnak a csomag átvételekor.</p>
                            </div>
                        </div>
                        <span class="text-xs font-extrabold text-gray-700">+ 490 Ft</span>
                    </label>

                    <!-- Banki átutalás -->
                    <label class="relative flex items-center justify-between p-4 sm:p-5 rounded-xl border border-gray-200 bg-white cursor-pointer transition-all hover:border-gray-300 hover:bg-gray-50">
                        <div class="flex items-center gap-4">
                            <input type="radio" name="payment_method" value="transfer" class="w-5 h-5 text-red-600 border-gray-300 focus:ring-red-500">
                            <div>
                                <span class="font-bold text-gray-900 text-sm sm:text-base">Előre utalás (Banki átutalás)</span>
                                <p class="text-xs text-gray-500 mt-0.5">Díjbekérőt küldünk e-mailben, az összeg beérkezése után indítjuk a csomagot.</p>
                            </div>
                        </div>
                        <span class="text-xs font-bold text-green-600 bg-green-50 px-2.5 py-1 rounded-md border border-green-200">Díjmentes</span>
                    </label>

                </div>
            </div>

            <!-- AKCIÓGOMBOK -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-2">
                <a href="{{ route('dataCheck') }}" class="w-full sm:w-auto px-6 py-3.5 rounded-xl border border-gray-300 text-gray-700 font-bold text-sm hover:bg-gray-100 transition-colors text-center flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Vissza az adatokhoz
                </a>
                
                <button type="submit" class="w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white font-extrabold px-10 py-3.5 rounded-xl shadow-lg transition-all flex items-center justify-center gap-2 text-sm uppercase tracking-wider">
                    <span>Tovább a rendelés összegzéséhez</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>

        </form>
    </div>
</section>