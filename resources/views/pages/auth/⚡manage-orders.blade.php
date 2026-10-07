<?php

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use App\Models\Order;

new #[Title('Rendelések')] class extends Component
{
    public array $orderStatus = [
        'pending' => 'Feldolgozás alatt',
        'shipped' => 'Szállítás alatt',
        'completed' => 'Teljesítve',
        'cancelled' => 'Törölve',
    ];

    public array $statusFilter = [];
    public $search = null;

    #[Computed]
    public function getOrders()
    {
        return Order::query()->with('orderItems.tire.brand')
                    ->when($this->statusFilter['status'] ?? null, function($query, $statusFilter) {
                        $query->where('status', $statusFilter);
                    })
                    ->when($this->search ?? null, function($query, $search) {
                        $query->where(function($q) use ($search) {
                            $q->where('order_number', 'like', "%" . $search . "%")
                            ->orWhere('customer_name', 'like', "%" . $search . "%");
                        });
                    })
                    ->latest()
                    ->get();
    }

    public function changeOrderStatus(Order $order, $value)
    {
        $order->update(['status' => $value]);
    }
};
?>

<!-- ==================== ADMIN RENDELÉSKEZELŐ SECTION ==================== -->
<section class="max-w-6xl mx-auto px-2 sm:px-6 lg:px-8 py-4 sm:py-6 space-y-4 sm:space-y-6">

    <!-- Admin Fejléc -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <div class="flex items-center gap-2">
                <h2 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight">Rendelések Kezelése</h2>
                <span class="px-2 py-0.5 text-[10px] uppercase font-bold bg-red-100 text-red-700 rounded-md">Admin</span>
            </div>
            <p class="text-xs text-gray-500 mt-1">Az összes vásárlói megrendelés áttekintése és kezelése.</p>
        </div>
    </div>

    <!-- Kereső & Szűrő Sáv -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3 sm:p-4 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
        <div class="relative w-full sm:w-80">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Keresés rendelésre, vevőre..." class="w-full pl-9 pr-3 py-2 text-xs rounded-lg border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none">
            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>

        <div class="flex items-center justify-between sm:justify-end gap-2 w-full sm:w-auto">
            <span class="text-xs font-medium text-gray-500 whitespace-nowrap">Státusz:</span>
            <select wire:model.live="statusFilter.status" class="w-full sm:w-auto text-xs border border-gray-300 rounded-lg py-2 px-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-white text-gray-700 font-medium outline-none">
                <option value="">Összes</option>
                @foreach ($this->orderStatus as $status => $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
                
            </select>
        </div>
    </div>

    <!-- Rendelések Listája -->
    <div class="space-y-4">

        <!-- 1. RENDELÉSI BLOKK -->
        @foreach ($this->getOrders as $order)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden transition-all hover:border-gray-300">

                <!-- Blokk Fejléc: Adatok, Vevő & Státusz váltó -->
                <div class="bg-gray-50/80 p-3 sm:p-5 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">

                    <!-- Vevő és rendelés infók -->
                    <div class="grid grid-cols-2 sm:flex sm:flex-wrap items-center gap-2 sm:gap-4 text-left">
                        <div>
                            <span class="text-[10px] uppercase font-bold text-gray-400 block tracking-wider">Rendelésszám</span>
                            <span class="text-xs sm:text-sm font-black text-gray-900">{{ $order->order_number }}</span>
                        </div>
                        <div class="h-8 w-px bg-gray-200 hidden sm:block"></div>
                        <div>
                            <span class="text-[10px] uppercase font-bold text-gray-400 block tracking-wider">Dátum</span>
                            <span class="text-xs font-semibold text-gray-700">{{ $order->created_at }}</span>
                        </div>
                        <div class="h-8 w-px bg-gray-200 hidden sm:block"></div>
                        <div class="col-span-2 sm:col-span-1 border-t sm:border-t-0 pt-2 sm:pt-0 border-gray-200/60">
                            <span class="text-[10px] uppercase font-bold text-gray-400 block tracking-wider">Megrendelő</span>
                            <span class="text-xs font-bold text-gray-900 block truncate">{{ $order->customer_name }}</span>
                            <span class="text-[10px] text-gray-500 block truncate">{{ $order->customer_email }} | {{ $order->customer_phone }}</span>
                        </div>
                    </div>

                    <!-- Státusz Módosító Legördülő Menü -->
                    <div class="pt-2 sm:pt-0 border-t sm:border-t-0 border-gray-200 flex items-center justify-between sm:justify-end gap-2">
                        <span class="text-[10px] uppercase font-bold text-gray-400 sm:hidden">Státusz módosítása:</span>
                        <select wire:change="changeOrderStatus({{ $order }}, $event.target.value)" class="text-xs font-bold border border-amber-300 rounded-lg py-1.5 px-2.5 bg-amber-50 text-amber-800 focus:ring-2 focus:ring-red-500 outline-none cursor-pointer w-full sm:w-auto">
                            @foreach ($orderStatus as $status => $key)
                                <option value="{{ $key }}" @selected($order->status === $key)>
                                    {{ $key }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Tétel, Címek és Ár Infók -->
                <div class="p-3 sm:p-5 space-y-4">

                    <!-- Termék adatok -->
                    @foreach ($order->orderItems as $item)
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gray-100 rounded-lg border border-gray-200 shrink-0 flex items-center justify-center font-bold text-[9px] sm:text-[10px] text-gray-400 uppercase">

                            </div>
                            <div class="min-w-0 flex-1">
                                <h4 class="text-xs sm:text-sm font-bold text-gray-900 truncate">{{ $item->tire->brand->name }} {{ $item->tire->pattern }}</h4>
                                <p class="text-[11px] sm:text-xs text-gray-500">{{ $item->tire->width }}/{{ $item->tire->profile }} R{{ $item->tire->diameter }} {{ $item->tire->load_index }}{{ $item->tire->speed_index }} | {{ $item->tire->season }} | <span class="font-semibold text-gray-700">4 db</span> × 38.500 Ft</p>
                            </div>
                        </div>
                    @endforeach
                    

                    <!-- Szállítási ÉS Számlázási Adatok Blokk -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-3 border-t border-gray-100 text-xs">
                        <div class="bg-gray-50 p-2.5 rounded-lg border border-gray-100">
                            <span class="text-[10px] uppercase font-bold text-gray-400 block tracking-wider mb-0.5">Szállítási Adatok</span>
                            <p class="font-semibold text-gray-800">{{ $order->billing_name }}</p>
                            <p class="font-semibold text-gray-800">{{ $order->billing_zip }} {{ $order->billing_city }}, {{ $order->billing_address }}</p>
                            <span class="text-[10px] text-gray-500 block mt-0.5">{{ $order->shipping_method }}</span>
                        </div>
                        <div class="bg-gray-50 p-2.5 rounded-lg border border-gray-100">
                            <span class="text-[10px] uppercase font-bold text-gray-400 block tracking-wider mb-0.5">Számlázási Adatok</span>
                            <p class="font-semibold text-gray-800">{{ $order->billing_name }}</p>
                            <p class="text-gray-600">{{ $order->billing_zip }} {{ $order->billing_city }}, {{ $order->billing_address }}</p>
                            <span class="text-[10px] text-gray-500 block mt-0.5">Adószám: {{ $order->billing_tax_number }}</span>
                        </div>
                    </div>

                    <!-- Végösszeg & Fizetés -->
                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                        <div>
                            <span class="text-[10px] uppercase font-bold text-gray-400 block tracking-wider">Fizetési mód</span>
                            <span class="text-xs font-semibold text-gray-700">{{ $order->payment_method }}</span>
                        </div>
                        <div class="text-right">
                            <span class="text-[10px] uppercase font-bold text-gray-400 block tracking-wider">Végösszeg</span>
                            <span class="text-base sm:text-lg font-black text-gray-900">{{ number_format($order->total_price, 0, ',', ' ') }} Ft</span>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
        

    </div>

</section>