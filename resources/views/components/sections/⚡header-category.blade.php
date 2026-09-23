<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<!-- ==================== KATEGÓRIÁK ==================== -->
    <section id="kategoriak" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="text-center max-w-xl mx-auto">
                <span class="text-xs font-extrabold text-red-600 uppercase tracking-widest">Kategóriák</span>
                <h2 class="text-3xl font-black text-slate-900 uppercase mt-1">Válassz Évszak Szerint</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <a href="#" class="group relative rounded-2xl overflow-hidden bg-slate-900 text-white p-8 border-b-4 border-red-600 shadow-xl flex flex-col justify-between h-64 hover:-translate-y-1 transition-transform">
                    <div class="z-10">
                        <span class="bg-red-600 text-xs font-bold px-2.5 py-1 rounded-full uppercase">Forró Aszfaltra</span>
                        <h3 class="text-2xl font-black uppercase mt-3">Nyári Gumik</h3>
                        <p class="text-xs text-slate-400 mt-1">Maximális tapadás és alacsony gördülési ellenállás.</p>
                    </div>
                    <span class="z-10 text-xs font-bold uppercase tracking-wider text-red-500 group-hover:text-white flex items-center gap-1 transition-colors">
                        Böngészés &rarr;
                    </span>
                    <div class="absolute -bottom-6 -right-6 text-slate-800 opacity-20 font-black text-9xl group-hover:scale-110 transition-transform">SUM</div>
                </a>

                <a href="#" class="group relative rounded-2xl overflow-hidden bg-slate-900 text-white p-8 border-b-4 border-red-600 shadow-xl flex flex-col justify-between h-64 hover:-translate-y-1 transition-transform">
                    <div class="z-10">
                        <span class="bg-slate-700 text-xs font-bold px-2.5 py-1 rounded-full uppercase">Hóba & Fagyba</span>
                        <h3 class="text-2xl font-black uppercase mt-3">Téli Gumik</h3>
                        <p class="text-xs text-slate-400 mt-1">Kiemelkedő fékút havon, jeges utakon és vizes felületen.</p>
                    </div>
                    <span class="z-10 text-xs font-bold uppercase tracking-wider text-red-500 group-hover:text-white flex items-center gap-1 transition-colors">
                        Böngészés &rarr;
                    </span>
                    <div class="absolute -bottom-6 -right-6 text-slate-800 opacity-20 font-black text-9xl group-hover:scale-110 transition-transform">WIN</div>
                </a>

                <a href="#" class="group relative rounded-2xl overflow-hidden bg-slate-900 text-white p-8 border-b-4 border-red-600 shadow-xl flex flex-col justify-between h-64 hover:-translate-y-1 transition-transform">
                    <div class="z-10">
                        <span class="bg-red-600 text-xs font-bold px-2.5 py-1 rounded-full uppercase">Egész Éves Kényelem</span>
                        <h3 class="text-2xl font-black uppercase mt-3">Négyévszakos</h3>
                        <p class="text-xs text-slate-400 mt-1">Kompromisszummentes megoldás városi használatra.</p>
                    </div>
                    <span class="z-10 text-xs font-bold uppercase tracking-wider text-red-500 group-hover:text-white flex items-center gap-1 transition-colors">
                        Böngészés &rarr;
                    </span>
                    <div class="absolute -bottom-6 -right-6 text-slate-800 opacity-20 font-black text-9xl group-hover:scale-110 transition-transform">ALL</div>
                </a>
            </div>
        </div>
    </section>