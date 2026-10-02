<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Models\ShippingMethod;
use App\Models\PaymentMethod;
use App\Services\CartService;

new #[Layout('layouts::site'), Title('GumiPro - Szállítási és fizetési mód')] class extends Component
{
    public $shippingMethods;
    public $paymentMethods;

    public $selectedShipping;
    public $selectedPayment;

    public function mount()
    {
        $this->shippingMethods = ShippingMethod::all();
        $this->paymentMethods = PaymentMethod::all();

        $this->selectedShipping = session('checkout.shipping_method_id');
        $this->selectedPayment = session('checkout.payment_method_id');
    }

    public function savePaymentAndShippingMethod()
    {
        session()->put([
            'checkout.shipping_method_id' => $this->selectedShipping,
            'checkout.payment_method_id' => $this->selectedPayment,
        ]);

        return redirect()->route('checkout');
    }
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

        <form wire:submit="savePaymentAndShippingMethod" class="space-y-8">
            
            <!-- 1. SZÁLLÍTÁSI MÓDOK -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8 space-y-6">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                    <h2 class="text-lg font-extrabold text-gray-900 flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-red-600"></span>
                        1. Szállítási Mód Kiválasztása
                    </h2>
                </div>

                <div class="space-y-3">

                    @foreach ($shippingMethods as $shippingMethod)
                        <label class="relative flex items-center justify-between p-4 sm:p-5 rounded-xl border border-gray-200 bg-white cursor-pointer transition-all hover:border-gray-300 hover:bg-gray-50">
                            <div class="flex items-center gap-4">
                                <input required wire:model.live="selectedShipping" type="radio" name="shipping_method" value="{{ $shippingMethod->id }}" class="w-5 h-5 text-red-600 border-gray-300 focus:ring-red-500">
                                <div>
                                    <span class="font-bold text-gray-900 text-sm sm:text-base">{{ $shippingMethod->name }}</span>
                                </div>
                            </div>
                            <div class="text-right shrink-0">
                                <span class="block text-sm sm:text-base font-extrabold text-gray-900">+ {{ $shippingMethod->cost }} Ft</span>
                            </div>
                        </label>
                    @endforeach
                    

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

                    @foreach ($paymentMethods as $paymentMethod)
                        <label class="relative flex items-center justify-between p-4 sm:p-5 rounded-xl border border-gray-200 bg-white cursor-pointer transition-all hover:border-gray-300 hover:bg-gray-50">
                            <div class="flex items-center gap-4">
                                <input required wire:model.live="selectedPayment" type="radio" name="payment_method" value="{{ $paymentMethod->id }}" class="w-5 h-5 text-red-600 border-gray-300 focus:ring-red-500">
                                <div>
                                    <span class="font-bold text-gray-900 text-sm sm:text-base">{{ $paymentMethod->name }}</span>
                                </div>
                            </div>
                            <span class="text-xs font-extrabold text-gray-700">+ {{ $paymentMethod->cost }} Ft</span>
                        </label>
                    @endforeach
                    

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
                
                <button type="submit" class="cursor-pointer w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white font-extrabold px-10 py-3.5 rounded-xl shadow-lg transition-all flex items-center justify-center gap-2 text-sm uppercase tracking-wider">
                    <span>Tovább a rendelés összegzéséhez</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>

        </form>
    </div>
</section>