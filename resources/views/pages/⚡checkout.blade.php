<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

new #[Layout('layouts::site'), Title('GumiPro - Összegzés')] class extends Component
{
    //
};
?>

<!-- ==================== AUTÓGUMI WEBSHOP - 3. LÉPÉS: RENDELÉS ÖSSZEGZÉSE ==================== -->
<section class="bg-gray-50 min-h-screen py-8 px-4 sm:px-6 lg:px-8 text-gray-800">
    <div class="max-w-4xl mx-auto space-y-8">
        
        <!-- Oldal Fejléc -->
        <div class="text-center">
            <span class="text-xs font-extrabold uppercase tracking-widest text-red-600 bg-red-50 px-3 py-1 rounded-full border border-red-100 inline-block mb-2">
                3. Lépés
            </span>
            <h1 class="text-2xl sm:text-3xl font-black text-gray-900 uppercase tracking-tight">Rendelés Összegzése</h1>
            <p class="text-sm text-gray-500 mt-1 max-w-lg mx-auto">
                Kérjük, ellenőrizd az adataidat és a megrendelni kívánt abroncsokat a véglegesítés előtt.
            </p>
        </div>

        <form action="#" method="POST" class="space-y-6">
            
            <!-- 1. MEGADOTT ADATOK ÁTTEKINTÉSE -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden divide-y divide-gray-100">
                
                <!-- Számlázási Adatok -->
                <div class="p-6 sm:p-8 flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-600"></span>
                            <h3 class="text-xs font-extrabold text-gray-400 uppercase tracking-wider">Számlázási Adatok</h3>
                        </div>
                        <p class="text-base font-bold text-gray-900">Kovács János</p>
                        <p class="text-sm text-gray-600">Kossuth Lajos utca 12. 2/4.</p>
                        <p class="text-sm text-gray-600">3300 Eger, Magyarország</p>
                        <p class="text-xs text-gray-400 mt-1">Adószám: <span class="text-gray-600 font-medium">-</span></p>
                    </div>
                    <a href="#" class="inline-flex items-center gap-1.5 text-xs font-bold text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 px-3 py-2 rounded-lg transition-colors self-start">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                        Módosítás
                    </a>
                </div>

                <!-- Szállítási & Kapcsolattartási Adatok -->
                <div class="p-6 sm:p-8 flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-slate-900"></span>
                            <h3 class="text-xs font-extrabold text-gray-400 uppercase tracking-wider">Szállítás & Kapcsolat</h3>
                        </div>
                        <p class="text-base font-bold text-gray-900">Kovács János</p>
                        <p class="text-sm text-gray-600">Kossuth Lajos utca 12. 2/4.</p>
                        <p class="text-sm text-gray-600">3300 Eger, Magyarország</p>
                        <div class="pt-2 text-xs text-gray-500 space-y-0.5">
                            <p><strong>Tel:</strong> +36 30 123 4567</p>
                            <p><strong>E-mail:</strong> kovacs.janos@example.com</p>
                            <p class="italic text-gray-400 pt-1">Megjegyzés: Kérem a gumikat a műhely mögötti garázsnál lerakni.</p>
                        </div>
                    </div>
                    <a href="#" class="inline-flex items-center gap-1.5 text-xs font-bold text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 px-3 py-2 rounded-lg transition-colors self-start">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                        Módosítás
                    </a>
                </div>

                <!-- Szállítási és Fizetési Mód -->
                <div class="p-6 sm:p-8 grid grid-cols-1 sm:grid-cols-2 gap-6 bg-gray-50/50">
                    <div>
                        <h4 class="text-xs font-extrabold text-gray-400 uppercase tracking-wider mb-1">Választott Szállítás</h4>
                        <p class="text-sm font-bold text-gray-900 flex items-center gap-2">
                            <span>DPD Gumiabroncs Futár</span>
                            <span class="text-xs font-semibold text-gray-600 bg-gray-200 px-2 py-0.5 rounded">3.960 Ft (4 db)</span>
                        </p>
                    </div>
                    <div>
                        <h4 class="text-xs font-extrabold text-gray-400 uppercase tracking-wider mb-1">Választott Fizetés</h4>
                        <p class="text-sm font-bold text-gray-900">Utánvét (Készpénz / Kártya a futárnál)</p>
                    </div>
                </div>

            </div>

            <!-- 2. MEGRENDELT ABRONCSOK LISTÁJA -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 sm:p-8 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-lg font-black text-gray-900 uppercase tracking-wide">
                        Megrendelt Abroncsok (1 tétel / 4 db)
                    </h2>
                    <a href="#" class="text-xs font-bold text-red-600 hover:underline">Kosár szerkesztése</a>
                </div>

                <div class="divide-y divide-gray-100">
                    <!-- 1. Gumi Tétel -->
                    <div class="p-6 flex items-center gap-4 sm:gap-6">
                        <div class="w-16 h-16 bg-gray-100 rounded-xl flex-shrink-0 flex items-center justify-center font-bold text-[10px] text-gray-400 border border-gray-200 text-center leading-tight">
                            GUMI<br>KÉP
                        </div>
                        <div class="flex-1 min-w-0">
                            <span class="text-[10px] font-black uppercase bg-gray-100 text-gray-700 px-2 py-0.5 rounded tracking-wider">Téli Gumi</span>
                            <h3 class="text-sm sm:text-base font-bold text-gray-900 truncate mt-1">Michelin Alpin 6</h3>
                            <p class="text-xs font-semibold text-gray-600 mt-0.5">205/55 R16 91H</p>
                            <p class="text-[11px] text-gray-400 mt-0.5">DOT: 2024 | EAN: 3528701234567</p>
                            <p class="text-xs text-gray-600 font-semibold mt-1 sm:hidden">4 db × 38.500 Ft</p>
                        </div>
                        <div class="hidden sm:block text-right">
                            <span class="text-xs text-gray-400 block">4 db × 38.500 Ft</span>
                            <span class="text-base font-extrabold text-gray-900">154.000 Ft</span>
                        </div>
                        <div class="sm:hidden text-right">
                            <span class="text-base font-extrabold text-gray-900">154.000 Ft</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. PÉNZÜGYI ÖSSZEGZÉS & JÓVÁHAGYÁS -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8 space-y-6">
                
                <div class="space-y-3 text-sm max-w-sm ml-auto">
                    <div class="flex justify-between text-gray-600">
                        <span>Abroncsok részösszege:</span>
                        <span class="font-semibold text-gray-900">154.000 Ft</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Környezetvédelmi termékdíj:</span>
                        <span class="font-semibold text-gray-900">Tartalmazza</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Szállítási díj (4 db):</span>
                        <span class="font-semibold text-gray-900">3.960 Ft</span>
                    </div>
                    <div class="flex justify-between text-lg sm:text-xl font-black text-gray-900 pt-4 border-t border-gray-200">
                        <span>Fizetendő végösszeg:</span>
                        <span class="text-red-600">157.960 Ft</span>
                    </div>
                </div>

                <!-- ÁSZF & Jogi Nyilatkozat Checkbox -->
                <div class="pt-4 border-t border-gray-100">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="accept_terms" required class="w-5 h-5 mt-0.5 text-red-600 rounded border-gray-300 focus:ring-red-500 flex-shrink-0">
                        <span class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                            Elolvastam és elfogadom az <a href="#" class="text-red-600 underline font-bold">Általános Szerződési Feltételeket (ÁSZF)</a>, valamint hozzájárulok adataim kezeléséhez az <a href="#" class="text-red-600 underline font-bold">Adatkezelési Tájékoztatóban</a> foglaltak szerint. <span class="text-red-500">*</span>
                        </span>
                    </label>
                </div>

                <!-- AKCIÓGOMBOK -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4">
                    <a href="#" class="w-full sm:w-auto px-6 py-3.5 rounded-xl border border-gray-300 text-gray-700 font-bold text-sm hover:bg-gray-100 transition-colors text-center flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Vissza az adatokhoz
                    </a>
                    
                    <button type="submit" class="w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white font-extrabold px-12 py-4 rounded-xl shadow-xl transition-all flex items-center justify-center gap-3 text-base uppercase tracking-wider">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Rendelés Véglegesítése</span>
                    </button>
                </div>

            </div>

        </form>
    </div>
</section>