<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

new #[Layout('layouts::site'), Title('GumiPro - Köszönet')] class extends Component
{
    public $orderNumber;
    
    public function mount($order)
    {
        $this->orderNumber = $order;
    }
};
?>

<!-- ==================== AUTÓGUMI WEBSHOP - RENDELÉS SIKERES / KÖSZÖNŐ OLDAL (MINIMAL) ==================== -->
<section class="bg-gray-50 min-h-screen py-12 px-4 sm:px-6 lg:px-8 text-gray-800 flex items-center justify-center">
    <div class="max-w-xl w-full">
        
        <!-- SIKERES RENDELÉS KÁRTYA -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 sm:p-12 text-center space-y-6">
            
            <!-- Zöld Pipáló Ikon -->
            <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto border-4 border-green-50 shadow-sm">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <!-- Cím és Üzenet -->
            <div class="space-y-2">
                <span class="text-xs font-black uppercase tracking-widest text-green-600 bg-green-50 px-3 py-1 rounded-full border border-green-100 inline-block">
                    Sikeres megrendelés
                </span>
                <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight uppercase pt-2">
                    Köszönjük a rendelést!
                </h1>
            </div>

            <!-- KIEMELT RENDELÉS AZONOSÍTÓ -->
            <div class="py-2">
                <div class="inline-flex flex-col sm:flex-row items-center justify-center gap-2 bg-gray-50 border border-gray-200 px-6 py-4 rounded-xl w-full">
                    <span class="text-xs uppercase font-extrabold text-gray-500 tracking-wider">Rendelés azonosító:</span>
                    <span class="text-xl font-black text-red-600 tracking-widest">{{ $orderNumber }}</span>
                </div>
            </div>

            <!-- AKCIÓGOMBOK -->
            <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ route('home') }}" class="w-full sm:w-auto bg-slate-900 hover:bg-black text-white font-extrabold px-8 py-3.5 rounded-xl shadow-md transition-all flex items-center justify-center gap-2 text-xs uppercase tracking-wider">
                    <span>Vissza a főoldalra</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>

        </div>

    </div>
</section>