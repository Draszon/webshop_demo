<?php

use Livewire\Component;
use App\Models\Brand;
use App\Models\Category;
use Livewire\Attributes\Computed;

new class extends Component
{
    public array $widthFilter = [155, 165, 175, 185, 195, 205, 215, 225, 235, 245, 255, 265, 275, 285, 295];
    
    public array $profileFilter = [30, 35, 40, 45, 50, 55, 60, 65, 70, 75, 80];

    public array $diameterFilter = [13, 14, 15, 16, 17, 18, 19, 20, 21, 22];

    public array $seasonFilter = [
        'nyári'         => 'Nyári',
        'téli'          => 'Téli',
        'négyévszakos'  => 'Négyévszakos',
    ];

    public array $sortPriceFilter = [
        'asc' => 'Ár szerint növekvő',
        'desc' => 'Ár szerint csökkenő',
    ];

    #[Computed]
    public function getBrand()
    {
        return Brand::all();
    }

    #[Computed]
    public function getCategory()
    {
        return Category::all();
    }

    public array $selectedFilters = [];

    public function search()
    {
        return $this->redirectRoute('filter', $this->selectedFilters);
    }
};
?>

    <!-- ==================== HERO + KITERJESZTETT GYORSKERESŐ ==================== -->
    <section class="relative bg-slate-900 text-white py-12 lg:py-16 border-b-4 border-red-600 overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ef4444_1px,transparent_1px)] bg-size-[20px_20px]"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                
                <!-- Hero Szöveg -->
                <div class="lg:col-span-4 space-y-4 text-center lg:text-left">
                    <span class="inline-block bg-red-600/20 text-red-500 border border-red-500/30 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-widest">
                        Garantált tapadás minden úton
                    </span>
                    <h1 class="text-3xl sm:text-5xl font-black uppercase tracking-tight leading-none">
                        Válaszd <span class="text-red-500">a biztonságot</span> autódra!
                    </h1>
                    <p class="text-slate-400 text-sm">
                        Találd meg a tökéletes abroncsot a legnépszerűbb márkák kínálatából.
                    </p>
                </div>

                <!-- Bővített Gumi Kereső Form -->
                <div class="lg:col-span-8 bg-white text-slate-800 p-6 rounded-2xl shadow-2xl border border-slate-100">
                    <div class="flex items-center justify-between border-b pb-3 mb-4 border-slate-200">
                        <h2 class="text-lg font-black text-slate-900 uppercase flex items-center gap-2">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Részletes Gumiabroncs Kereső
                        </h2>
                        <span class="text-xs font-bold text-slate-400 uppercase">Összes paraméter</span>
                    </div>

                    <form wire:submit="search" class="space-y-4">
                        <!-- 1. Sor: Méretek és Évszak -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Szélesség</label>
                                <select wire:model="selectedFilters.width" class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 font-semibold">
                                    <option value="">Összes</option>
                                    @foreach ($this->widthFilter as $width)
                                        <option value="{{ $width }}">{{ $width }}mm</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Profil</label>
                                <select wire:model="selectedFilters.profile" class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 font-semibold">
                                    <option value="">Összes</option>
                                    @foreach ($this->profileFilter as $profile)
                                        <option value="{{ $profile }}">{{ $profile }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Átmérő</label>
                                <select wire:model="selectedFilters.diameter" class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 font-semibold">
                                    <option value="">Összes</option>
                                    @foreach ($this->diameterFilter as $diameter)
                                        <option value="{{ $diameter }}">R{{ $diameter }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Évszak</label>
                                <select wire:model="selectedFilters.season" class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 font-semibold">
                                    <option value="">Összes</option>
                                    @foreach ($this->seasonFilter as $season => $value)
                                        <option value="{{ $season }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- 2. Sor: Kategória, Gyártó, Rendezés -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-1">
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Kategória</label>
                                <select wire:model="selectedFilters.category" class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 font-semibold">
                                    <option value="">Összes</option>
                                    @foreach ($this->getCategory as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Gyártó / Márka</label>
                                <select wire:model="selectedFilters.brand" class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 font-semibold">
                                    <option value="">Összes</option>
                                    @foreach ($this->getBrand as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Ár Rendezés</label>
                                <select wire:model="selectedFilters.sortPrice" class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 font-semibold">
                                    <option value="">Összes</option>
                                    @foreach ($this->sortPriceFilter as $price => $value)
                                        <option value="{{ $price }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full py-3.5 px-6 text-sm font-black text-white bg-red-600 hover:bg-red-700 rounded-xl shadow-lg transition-all flex items-center justify-center gap-2 uppercase tracking-wider cursor-pointer">
                                <span>Abroncsok Keresése</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>