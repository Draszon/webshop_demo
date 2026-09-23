<?php

/**
 * Livewire komponens a gumiabroncsok szűrésére, listázására és kosárba helyezésére.
 */
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Tire;
use App\Services\CartService;

new #[Layout('layouts::site'), Title('Autógumi webshop')] class extends Component
{
    public array $filteredSearch = [];
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

    /**
     * Visszaadja a szűrőben kiválasztható márkákat.
     */
    #[Computed]
    public function getBrand()
    {
        return Brand::all();
    }

    /**
     * Visszaadja a szűrőben kiválasztható gumiabroncs-kategóriákat.
     */
    #[Computed]
    public function getCategory()
    {
        return Category::all();
    }    

    /**
     * Beállítja a szűrőket az URL query paramétereiből a komponens betöltésekor.
     */
    public function mount()
    {
        $this->filteredSearch = request()->query();
    }

    /**
     * A kiválasztott szűrők alapján lekéri a megjelenítendő gumiabroncsokat.
     */
    #[Computed]
    public function tires()
    {
        return Tire::query()->with('brand')->with('category')
            ->when($this->filteredSearch['width'] ?? null, function($query, $widthFilter) {
                $query->where('width', $widthFilter);
            })
            ->when($this->filteredSearch['profile'] ?? null, function($query, $profile) {
                $query->where('profile', $profile);
            })
            ->when($this->filteredSearch['diameter'] ?? null, function($query, $diameter) {
                $query->where('diameter', $diameter);
            })
            ->when($this->filteredSearch['season'] ?? null, function($query, $season) {
                $query->where('season', $season);
            })
            ->when($this->filteredSearch['category'] ?? null, function($query, $category) {
                $query->where('category_id', $category);
            })
            ->when($this->filteredSearch['brand'] ?? null, function($query, $brand) {
                $query->where('brand_id', $brand);
            })
            ->when(in_array($this->filteredSearch['sortPrice'] ?? null, ['asc', 'desc']), function($query) {
                $query->orderBy('price', $this->filteredSearch['sortPrice']);
            })
            ->get();
    }

    /**
     * Törli az összes aktív szűrőfeltételt.
     */
    public function resetFilter()
    {
        $this->filteredSearch = [];
    }

    /**
     * Kiüríti a munkamenetben tárolt adatokat.
     */
    public function sessionFlush()
    {
        session()->flush();
    }

    /**
     * Fejlesztési célból kiírja a munkamenet aktuális kosártartalmát.
     */
    public function dumpCart()
    {
        dd(session('cart'));
    }

    /**
     * A megadott mennyiségű gumiabroncsot a kosárhoz adja, majd frissítési eseményt küld.
     */
    public function storeCart(CartService $cartService, int $tireId, int $quantity)
    {
        $cartService->add($tireId, $quantity);
        $this->dispatch('cart-update');
    }
};
?>

<!-- ==================== KATALÓGUS SZEKCIÓ (SZŰRŐ + KÁRTYÁK) ==================== -->
<section class="bg-gray-100 py-10 px-4 sm:px-6 lg:px-8 text-gray-800">
    <div class="max-w-7xl mx-auto space-y-8">

    <!-- Bővített Gumi Kereső Form -->
                <div class="lg:col-span-8 bg-white text-slate-800 p-6 rounded-2xl shadow-2xl border border-slate-100">
                    <div class="flex items-center justify-between border-b pb-3 mb-4 border-slate-200">
                        <h2 class="text-lg font-black text-slate-900 uppercase flex items-center gap-2">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Részletes Gumiabroncs Kereső
                            <span wire:click="sessionFlush" class="cursor-pointer">session ürítése</span>
                            <span wire:click="dumpCart" class="cursor-pointer">Cart tartalma</span>
                        </h2>
                        <span wire:click="resetFilter" class="text-xs font-bold text-slate-400 uppercase cursor-pointer">Szűrők törlése</span>
                    </div>

                    <form class="space-y-4">
                        <!-- 1. Sor: Méretek és Évszak -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Szélesség</label>
                                <select wire:model.live="filteredSearch.width" class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 font-semibold">
                                    <option value="">Összes</option>
                                    @foreach ($widthFilter as $width)
                                        <option value="{{ $width }}">{{ $width }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Profil</label>
                                <select wire:model.live="filteredSearch.profile" class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 font-semibold">
                                    <option value="">Összes</option>
                                    @foreach ($profileFilter as $profile)
                                        <option value="{{ $profile }}">{{ $profile }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Átmérő</label>
                                <select wire:model.live="filteredSearch.diameter" class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 font-semibold">
                                    <option value="">Összes</option>
                                    @foreach ($diameterFilter as $diameter)
                                        <option value="{{ $diameter }}">{{ $diameter }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Évszak</label>
                                <select wire:model.live="filteredSearch.season" class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 font-semibold">
                                    <option value="">Összes</option>
                                    @foreach ($seasonFilter as $season => $value)
                                        <option value="{{ $season }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- 2. Sor: Kategória, Gyártó, Rendezés -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-1">
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Kategória</label>
                                <select wire:model.live="filteredSearch.category" class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 font-semibold">
                                    <option value="">Összes</option>
                                    @foreach ($this->getCategory as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Gyártó / Márka</label>
                                <select wire:model.live="filteredSearch.brand" class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 font-semibold">
                                    <option value="">Összes</option>
                                    @foreach ($this->getBrand as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-slate-600 mb-1">Ár Rendezés</label>
                                <select wire:model.live="filteredSearch.sortPrice" class="w-full text-xs px-3 py-2 bg-slate-50 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-600 font-semibold">
                                    <option value="">Összes</option>
                                    @foreach ($sortPriceFilter as $price => $value)
                                        <option value="{{ $price }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

        <!-- 2. TERMÉK KÁRTYÁK GRIDJE -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            <!-- KÁRTYA -->
            @foreach ($this->tires as $tire)
                <div class="bg-white border border-gray-200 rounded-2xl p-4 flex flex-col justify-between hover:border-gray-300 hover:shadow-md transition-all group">
                    
                    <div>
                        <!-- Felső jelvények -->
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 border border-blue-200 px-2.5 py-1 rounded-lg text-[11px] font-bold uppercase tracking-wider">
                                {{ $tire->season }}
                            </span>
                            <span class="text-[11px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-md">
                                Raktáron {{ $tire->stock }} db
                            </span>
                        </div>

                        <!-- Kép -->
                        <a href="#" class="block my-2 overflow-hidden rounded-xl bg-gray-50 p-4 border border-gray-100 group-hover:border-gray-200 transition-colors">
                            <img src="https://encrypted-tbn3.gstatic.com/licensed-image?q=tbn:ANd9GcTOaCK_LzJ0njMkM5Z8IJsM7m_PUCYaxK2ImxB3GL_PGxk5zAbZxyG-I3H7zKOr0s4rBw_N5ZNTr3QfkT4" 
                                 alt="Continental WinterContact TS 870" 
                                 class="w-full h-44 object-contain group-hover:scale-105 transition-transform duration-300">
                        </a>

                        <!-- Cím & Mintázat -->
                        <div class="mt-2">
                            <p class="text-xs font-bold text-red-600 uppercase tracking-widest">{{ $tire->brand->name }}</p>
                            <a href="#" class="text-base font-extrabold text-gray-900 hover:text-red-600 transition-colors line-clamp-1">
                                {{ $tire->pattern }}
                            </a>
                        </div>

                        <!-- Méret & Indexek -->
                        <div class="my-4 p-3 bg-gray-50 rounded-xl border border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="block text-[10px] text-gray-400 uppercase font-bold">Méret</span>
                                <span class="text-base font-black text-gray-800 tracking-tight">{{ $tire->width }}/{{ $tire->profile }} R{{ $tire->diameter }}</span>
                            </div>
                            <div class="text-right">
                                <span class="block text-[10px] text-gray-400 uppercase font-bold">Terhelés / Seb.</span>
                                <span class="text-sm font-bold text-gray-700">{{ $tire->load_index }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Ár & Kosár gomb -->
                    <div class="pt-3 border-t border-gray-100 flex items-center justify-between gap-2">
                        <div>
                            <span class="block text-[10px] text-gray-400 uppercase font-bold">Bruttó ár</span>
                            <span class="text-xl font-black text-gray-900">{{ number_format($tire->price, 0, ',', ' ') }}<span class="text-xs font-normal text-gray-500">Ft / db</span></span>
                        </div>
                        <button wire:click="storeCart({{ $tire->id }}, 4)" type="button" class="bg-red-600 hover:bg-red-700 text-white p-2.5 rounded-xl transition-colors shadow-md flex items-center justify-center" aria-label="Kosárba">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </button>
                    </div>

                </div>
            @endforeach
            

        </div>
    </div>
</section>