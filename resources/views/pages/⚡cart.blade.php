<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use App\Models\CartItem;
use App\Services\CartService;
use Illuminate\Support\Collection;

new #[Layout('layouts::site'), Title('GumiPro - Kosár')] class extends Component
{
    /**
     * Betölti a kosár aktuális tételeit a nézet számára.
     */
    #[Computed]
    public function getCartItems(): collection
    {
        return app(CartService::class)->getCartItems();
    }

    /**
     * Törli a kiválasztott tételt, majd értesíti a kosár többi komponensét a változásról.
     */
    public function removeItem(int $tireId, CartService $cartService): void
    {
        $cartService->removeItem($tireId);
        $this->dispatch('cart-update');
    }

    /**
     * Módosítja a tétel mennyiségét, majd frissítési eseményt küld a kapcsolódó nézeteknek.
     */
    public function quantityAdjust(int $tireId, CartService $cartService, string $direction): void
    {
        $cartService->quantityAdjust($tireId, $direction);
        $this->dispatch('cart-update');
    }

    /**
     * Kiszámolja a kosárban szereplő termékek összértékét szállítási díj nélkül.
     */
    #[Computed]
    public function sumPrice(): int
    {
        return app(CartService::class)->getCartItems()->sum(function ($item) {
            return $item->tire->price * $item->quantity;
        });
    }
};

?>

<!-- ==================== KOSÁR SZEKCIÓ (SECTION) ==================== -->
<section class="bg-gray-100 py-10 px-4 sm:px-6 lg:px-8 text-gray-800 min-h-[70vh]">
    <div class="max-w-7xl mx-auto space-y-8">

        <!-- Címsor & Vissza gomb -->
        <div class="flex items-center justify-between border-b border-gray-200 pb-4">
            <div>
                <h1 class="text-2xl font-black text-gray-900 tracking-tight">Bevásárlókosár</h1>
                <p class="text-xs font-semibold text-gray-500 mt-1">Összesen <span class="text-red-600 font-extrabold">{{ $this->getCartItems->count() }} tételt</span> adtál a kosárhoz</p>
            </div>
            <a href="{{ route('filter') }}" class="inline-flex items-center gap-2 text-xs font-bold text-gray-600 hover:text-red-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Vissza a vásárláshoz
            </a>
        </div>

        <!-- FŐ KOSÁR TARTALOM (Rács elrendezés) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

            <!-- 1. TERMÉKEK LISTÁJA (2 oszlopot foglal el) -->
            
                <div class="lg:col-span-2 space-y-4">
                    <!-- TÉTEL 1 -->
                    {{-- Minden kosártétel saját mennyiségállító és törlő műveletet kap. --}}
                    @foreach ($this->getCartItems as $cartItem)
                        
                        <div class="bg-white border border-gray-200 rounded-2xl p-4 sm:p-5 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">

                            <!-- Kép & Alapadatok -->
                            <div class="flex items-center gap-4 w-full sm:w-auto">
                                <div class="w-20 h-20 bg-gray-50 border border-gray-100 rounded-xl shrink-0 p-2 flex items-center justify-center">
                                    <img src="https://encrypted-tbn3.gstatic.com/licensed-image?q=tbn:ANd9GcTOaCK_LzJ0njMkM5Z8IJsM7m_PUCYaxK2ImxB3GL_PGxk5zAbZxyG-I3H7zKOr0s4rBw_N5ZNTr3QfkT4" 
                                         alt="Continental WinterContact TS 870" 
                                         class="w-full h-full object-contain">
                                </div>

                                <div>
                                    <span class="text-[10px] font-bold text-red-600 uppercase tracking-widest">{{ $cartItem->tire->brand->name }}</span>
                                    <h3 class="font-extrabold text-gray-900 text-sm sm:text-base leading-tight">{{ $cartItem->tire->pattern }}</h3>

                                    <!-- Méret & Szezon adatok -->
                                    <div class="flex flex-wrap items-center gap-2 mt-1">
                                        <span class="text-xs font-bold text-gray-700">{{ $cartItem->tire->width }}/{{ $cartItem->tire->profile }} R{{ $cartItem->tire->diameter }} {{ $cartItem->tire->load_index }}V</span>
                                        <span class="text-gray-300">•</span>
                                        <span class="inline-flex items-center text-[10px] font-bold text-blue-700 bg-blue-50 border border-blue-200 px-1.5 py-0.5 rounded">{{ $cartItem->tire->season }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Mennyiség állító & Ár & Törlés -->
                            <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto pt-3 sm:pt-0 border-t sm:border-t-0 border-gray-100">

                                <!-- Mennyiség léptető -->
                                <div class="flex items-center border border-gray-300 rounded-xl bg-gray-50 overflow-hidden">
                                    <button wire:click="quantityAdjust({{ $cartItem->tire->id }}, 'down')" type="button" class="w-8 h-8 flex items-center justify-center text-gray-600 hover:bg-gray-200 font-bold transition-colors">-</button>
                                    <input type="text" :value="{{ $cartItem->quantity }}" class="w-10 text-center bg-transparent text-sm font-black text-gray-900 border-none focus:outline-none">
                                    <button wire:click="quantityAdjust({{ $cartItem->tire->id }}, 'up')" type="button" class="w-8 h-8 flex items-center justify-center text-gray-600 hover:bg-gray-200 font-bold transition-colors">+</button>
                                </div>

                                <!-- Egységár / Összár -->
                                <div class="text-right">
                                    <span class="block text-[10px] text-gray-400 font-bold uppercase">{{ number_format($cartItem->tire->price, 0, ',', ' ') }} Ft / db</span>
                                    <span class="text-base font-black text-gray-900">{{ number_format($cartItem->tire->price * $cartItem->quantity, 0, ',', ' ') }}<span class="text-xs font-normal text-gray-500">Ft</span></span>
                                </div>

                                <!-- Törlés gomb -->
                                <button wire:click="removeItem({{ $cartItem->tire->id }})" type="button" class="text-gray-400 hover:text-red-600 p-2 rounded-lg transition-colors" title="Tétel törlése">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
                    

            <!-- 2. RENDELÉS ÖSSZEGZŐ PANEL (Sötét kiemeléssel a jobb oldalon) -->
            <div class="lg:col-span-1">
                <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden sticky top-6">
                    
                    <!-- Sötét kiemelt fejléc -->
                    <div class="bg-slate-900 text-white px-6 py-4 flex items-center justify-between">
                        <h2 class="font-extrabold uppercase tracking-wider text-sm">Rendelés Összegzése</h2>
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>

                    <!-- Számítások -->
                    <div class="p-6 space-y-4 text-sm">
                        
                        <div class="flex justify-between text-gray-600">
                            <span>Termékek bruttó ára</span>
                            <span class="font-bold text-gray-800">{{ number_format($this->sumPrice, 0, ',', ' ') }} Ft</span>
                        </div>

                        <div class="flex justify-between text-gray-600 pb-4 border-b border-gray-100">
                            <span>Becsült szállítási díj</span>
                            <span class="font-bold text-emerald-600">{{ number_format(4500, 0, ',', ' ') }} Ft</span>
                        </div>

                        <!-- Végösszeg -->
                        <div class="pt-2 flex justify-between items-end">
                            <div>
                                <span class="block text-xs font-bold text-gray-400 uppercase">Fizetendő bruttó ár</span>
                                <span class="text-2xl font-black text-gray-900">{{ number_format($this->sumPrice + 4500, 0, ',', ' ') }} <span class="text-sm font-normal text-gray-500">Ft</span></span>
                            </div>
                        </div>

                        <!-- Akció gomb (Call to Action) -->
                        <a href="#" class="w-full bg-red-600 hover:bg-red-700 text-white font-extrabold py-3.5 px-6 rounded-xl transition-colors flex items-center justify-center gap-2 text-sm shadow-md mt-6">
                            Tovább a pénztárhoz
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>

                        <!-- Biztonsági garanciák -->
                        <div class="pt-4 flex items-center justify-center gap-4 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Garancia
                            </span>
                            <span>•</span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Gyors szállítás
                            </span>
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>
</section>