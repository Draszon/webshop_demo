<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<!-- ==================== KIEMELT AJÁNLATOK ==================== -->
    <section id="akciok" class="py-16 bg-slate-50 border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 border-b pb-4 border-slate-200">
                <div>
                    <span class="text-xs font-extrabold text-red-600 uppercase tracking-widest">Kiemelt Termékek</span>
                    <h2 class="text-3xl font-black text-slate-900 uppercase">Szezonális Legjobb Árak</h2>
                </div>
                <a href="#" class="text-sm font-bold text-red-600 hover:text-red-700 transition-colors flex items-center gap-1">
                    <span>Összes termék tekintése</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>

            <!-- Termék Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <div class="bg-white rounded-2xl border border-slate-200 p-5 space-y-4 hover:shadow-2xl transition-all flex flex-col justify-between relative group">
                    <span class="absolute top-4 left-4 z-10 bg-red-600 text-white text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase tracking-wider">Akció</span>
                    
                    <div class="aspect-square bg-slate-100 rounded-xl flex items-center justify-center p-4 relative overflow-hidden">
                        <div class="w-28 h-28 rounded-full border-8 border-slate-800 border-dashed flex items-center justify-center text-slate-400 group-hover:scale-105 transition-transform">
                            <span class="text-xs font-bold text-slate-500">MOCKUP</span>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <span class="text-xs text-slate-400 font-extrabold uppercase">Michelin</span>
                        <h3 class="font-bold text-slate-900 text-base line-clamp-1 group-hover:text-red-600 transition-colors">Pilot Sport 5</h3>
                        <p class="text-xs text-slate-500 font-mono font-bold">225/45 R17 94Y</p>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-400 line-through font-semibold">48 900 Ft</span>
                            <div class="text-xl font-black text-slate-900">42 500 <span class="text-xs font-normal">Ft</span></div>
                        </div>
                        <button type="button" class="p-3 bg-slate-900 hover:bg-red-600 text-white rounded-xl transition-colors shadow-md cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-5 space-y-4 hover:shadow-2xl transition-all flex flex-col justify-between relative group">
                    <div class="aspect-square bg-slate-100 rounded-xl flex items-center justify-center p-4 relative overflow-hidden">
                        <div class="w-28 h-28 rounded-full border-8 border-slate-800 border-dashed flex items-center justify-center text-slate-400 group-hover:scale-105 transition-transform">
                            <span class="text-xs font-bold text-slate-500">MOCKUP</span>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <span class="text-xs text-slate-400 font-extrabold uppercase">Continental</span>
                        <h3 class="font-bold text-slate-900 text-base line-clamp-1 group-hover:text-red-600 transition-colors">WinterContact TS 870</h3>
                        <p class="text-xs text-slate-500 font-mono font-bold">205/55 R16 91T</p>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                        <div>
                            <div class="text-xl font-black text-slate-900">36 900 <span class="text-xs font-normal">Ft</span></div>
                        </div>
                        <button type="button" class="p-3 bg-slate-900 hover:bg-red-600 text-white rounded-xl transition-colors shadow-md cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-5 space-y-4 hover:shadow-2xl transition-all flex flex-col justify-between relative group">
                    <span class="absolute top-4 left-4 z-10 bg-slate-900 text-white text-[10px] font-extrabold px-2.5 py-1 rounded-md uppercase tracking-wider">Népszerű</span>

                    <div class="aspect-square bg-slate-100 rounded-xl flex items-center justify-center p-4 relative overflow-hidden">
                        <div class="w-28 h-28 rounded-full border-8 border-slate-800 border-dashed flex items-center justify-center text-slate-400 group-hover:scale-105 transition-transform">
                            <span class="text-xs font-bold text-slate-500">MOCKUP</span>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <span class="text-xs text-slate-400 font-extrabold uppercase">Pirelli</span>
                        <h3 class="font-bold text-slate-900 text-base line-clamp-1 group-hover:text-red-600 transition-colors">Cinturato All Season SF2</h3>
                        <p class="text-xs text-slate-500 font-mono font-bold">195/65 R15 91H</p>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                        <div>
                            <div class="text-xl font-black text-slate-900">29 400 <span class="text-xs font-normal">Ft</span></div>
                        </div>
                        <button type="button" class="p-3 bg-slate-900 hover:bg-red-600 text-white rounded-xl transition-colors shadow-md cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-slate-200 p-5 space-y-4 hover:shadow-2xl transition-all flex flex-col justify-between relative group">
                    <div class="aspect-square bg-slate-100 rounded-xl flex items-center justify-center p-4 relative overflow-hidden">
                        <div class="w-28 h-28 rounded-full border-8 border-slate-800 border-dashed flex items-center justify-center text-slate-400 group-hover:scale-105 transition-transform">
                            <span class="text-xs font-bold text-slate-500">MOCKUP</span>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <span class="text-xs text-slate-400 font-extrabold uppercase">Hankook</span>
                        <h3 class="font-bold text-slate-900 text-base line-clamp-1 group-hover:text-red-600 transition-colors">Ventus Prime 4</h3>
                        <p class="text-xs text-slate-500 font-mono font-bold">215/55 R17 94V</p>
                    </div>

                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
                        <div>
                            <div class="text-xl font-black text-slate-900">38 100 <span class="text-xs font-normal">Ft</span></div>
                        </div>
                        <button type="button" class="p-3 bg-slate-900 hover:bg-red-600 text-white rounded-xl transition-colors shadow-md cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </section>