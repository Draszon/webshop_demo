<?php

use Livewire\Component;
use Livewire\Attributes\Title;

new #[Title('Rendeléseim')] class extends Component
{
    public $user;
    public $orders;

    public function mount()
    {
        $this->user = Auth::user();
        $this->orders = $this->user->orders()
            ->with('orderItems.tire.brand')
            ->latest()
            ->get();
    }
};
?>

<!-- ==================== RENDELÉSI ELŐZMÉNYEK SECTION ==================== -->
<section class="max-w-6xl mx-auto p-4 sm:p-6 lg:p-8 space-y-6">

    <!-- Section Fejléc -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Rendelési Előzmények</h2>
            <p class="text-xs text-gray-500 mt-1">Kövesd nyomon korábbi gumiabroncs megrendeléseidet.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="text-right">
                <span class="block text-sm font-bold text-gray-900">{{ $this->user->name }}</span>
                <span class="block text-xs text-gray-500">{{ $this->user->email }}</span>
            </div>
        </div>
    </div>

    <!-- Kereső & Szűrő Sáv -->
    <!--<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="relative w-full sm:w-80">
            <input type="text" placeholder="Keresés rendelésszámra vagy márkára..." class="w-full pl-10 pr-4 py-2 text-xs rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none">
            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>

        <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
            <span class="text-xs font-medium text-gray-500">Státusz:</span>
            <select class="text-xs border border-gray-300 rounded-lg py-2 px-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-gray-700 font-medium outline-none">
                <option value="">Összes rendelés</option>
                <option value="pending" selected>Feldolgozás alatt</option>
                <option value="shipped">Szállítás alatt</option>
                <option value="completed">Teljesített</option>
                <option value="cancelled">Törölve</option>
            </select>
        </div>
    </div>-->

    <!-- Rendelések Listája -->
    <div class="space-y-4">
        
        <!-- RENDELÉS: Feldolgozás alatt -->
        @foreach ($this->orders as $order)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden transition-all hover:border-gray-300">
                <div class="bg-gray-50/80 p-4 sm:p-5 border-b border-gray-200 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div>
                            <span class="text-[10px] uppercase font-bold text-gray-400 block tracking-wider">Rendelésszám</span>
                            <span class="text-sm font-black text-gray-900">{{ $order->order_number }}</span>
                        </div>
                        <div class="h-8 w-px bg-gray-200 hidden sm:block"></div>
                        <div>
                            <span class="text-[10px] uppercase font-bold text-gray-400 block tracking-wider">Dátum</span>
                            <span class="text-xs font-semibold text-gray-700">{{ $order->created_at }}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                            {{ $order->status }}
                        </span>
                    </div>
                </div>

                <div class="p-4 sm:p-5 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="space-y-3 flex-1 min-w-0">
                        @foreach ($order->orderItems as $item)
                            <div class="flex items-center gap-4">
                                <div class="min-w-0">
                                    @if ($item->tire)
                                        <h4 class="text-xs sm:text-sm font-bold text-gray-900">{{ $item->tire->brand?->name }} {{ $item->tire->pattern }}</h4>
                                        <p class="text-xs text-gray-500">
                                            {{ $item->tire->width }}/{{ $item->tire->profile }} R{{ $item->tire->diameter }}
                                            {{ $item->tire->load_index }}{{ $item->tire->speed_index }}
                                            | {{ $item->tire->season }}
                                            | <span class="font-semibold text-gray-700">{{ $item->quantity }} db</span>
                                            × {{ number_format($item->unit_price, 0, ',', ' ') }} Ft
                                        </p>
                                    @else
                                        <p class="text-xs text-gray-500">A termék adatai már nem érhetők el.</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex items-center justify-between md:justify-end gap-6 pt-4 md:pt-0 border-t md:border-t-0 border-gray-100">
                        <div class="text-left md:text-right">
                            <span class="text-[10px] uppercase font-bold text-gray-400 block tracking-wider">Fizetendő</span>
                            <span class="text-base font-black text-gray-900">{{ number_format($order->total_price, 0, ',', ' ') }} Ft</span>
                        </div>
                    </div>
                </div>
            </div>        
        @endforeach

    </div>

</section>