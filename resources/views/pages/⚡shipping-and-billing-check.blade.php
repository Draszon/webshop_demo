<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

new #[Layout('layouts::site'), Title('GumiPro - Adatellenőrzés')] class extends Component
{
    //Számlázási adatok
    public $billing_name;
    public $billing_tax_number;
    public $billing_zip;
    public $billing_city;
    public $billing_address;

    //Szállítási adatok
    public $shipping_name;
    public $phone;
    public $email;
    public $shipping_zip;
    public $shipping_city;
    public $shipping_address;
    public $shipping_comment;

    public function mount()
    {
        $user = Auth::user();

        $this->billing_name = $user->billing_name;
        $this->billing_tax_number = $user->billing_tax_number;
        $this->billing_zip = $user->billing_zip;
        $this->billing_city = $user->billing_city;
        $this->billing_address = $user->billing_address;

        $this->shipping_name = $user->shipping_name;
        $this->phone = $user->phone;
        $this->email = $user->email;
        $this->shipping_zip = $user->shipping_zip;
        $this->shipping_city = $user->shipping_city;
        $this->shipping_address = $user -> shipping_address;
        $this->shipping_comment = $user->shipping_comment;
    }

    public function updateShipping()
    {
        $user = Auth::user();

        $validated = $this->validate(
            [
                'billing_name' => 'required|string|max:255',
                'billing_tax_number' => 'nullable|string|max:13',
                'billing_zip' => 'required|string|max:10',
                'billing_city' => 'required|string|max:255',
                'billing_address' => 'required|string|max:255',

                'shipping_name' => 'required|string|max:255',
                'phone' => 'required|string|max:30',
                'email' => 'required|email|max:255',
                'shipping_zip' => 'required|string|max:10',
                'shipping_city' => 'required|string|max:255',
                'shipping_address' => 'required|string|max:255',
                'shipping_comment' => 'nullable|string|max:500',
            ], [
                'name.required' => 'A számlázási név megadása kötelező.',
                'billing_zip.required' => 'A számlázási irányítószám megadása kötelező.',
                'billing_city.required' => 'A számlázási város megadása kötelező.',
                'billing_address.required' => 'A számlázási cím megadása kötelező.',

                'shipping_name.required' => 'Az átvevő nevének megadása kötelező.',
                'phone.required' => 'A telefonszám megadása kötelező a futár miatt.',
                'email.required' => 'Az e-mail cím megadása kötelező a visszaigazoláshoz.',
                'email.email' => 'Kérjük, érvényes e-mail címet adj meg.',
                'shipping_zip.required' => 'A szállítási irányítószám megadása kötelező.',
                'shipping_city.required' => 'A szállítási város megadása kötelező.',
                'shipping_address.required' => 'A szállítási cím megadása kötelező.',
                'shipping_comment.max' => 'A megjegyzés legfeljebb 500 karakter lehet.',
            ]
        );

        $user->fill($validated);
        $user->save();

        return redirect()->route('paymentAndShipping');
    }
};
?>

<!-- ==================== KOSÁR / CHECKOUT - KIZÁRÓLAG ADATELLENŐRZÉS ==================== -->
<section class="bg-gray-50 min-h-screen py-8 px-4 sm:px-6 lg:px-8 text-gray-800">
    <div class="max-w-4xl mx-auto">
        
        <!-- Oldal Fejléc -->
        <div class="mb-8 text-center">
            <span class="text-xs font-extrabold uppercase tracking-widest text-red-600 bg-red-50 px-3 py-1 rounded-full border border-red-100 inline-block mb-2">
                2. Lépés
            </span>
            <h1 class="text-2xl sm:text-3xl font-black text-gray-900 uppercase tracking-tight">Adatok Ellenőrzése</h1>
            <p class="text-sm text-gray-500 mt-1 max-w-lg mx-auto">
                Kérjük, ellenőrizd vagy módosítsd a szállítási és számlázási adataidat a folytatás előtt.
            </p>
        </div>

        <form wire:submit="updateShipping" class="space-y-6">
            
            <!-- FŐ KÁRTYA CONTAINER -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                
                <!-- 1. SZÁMLÁZÁSI ADATOK -->
                <div class="p-6 sm:p-8 space-y-6">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                        <h2 class="text-lg font-extrabold text-gray-900 flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-red-600"></span>
                            Számlázási Adatok
                        </h2>
                        <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Kötelező</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
                        <!-- billing_name -->
                        <div class="md:col-span-2 lg:col-span-2">
                            <label for="checkout_billing_name" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">
                                Számlázási Név / Cégnév
                            </label>
                            <input wire:model="billing_name" type="text" id="checkout_billing_name" name="billing_name" value="Kovács János" required
                                   class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:outline-none transition-all">
                            @error('billing_name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- billing_tax_number -->
                        <div class="md:col-span-2 lg:col-span-2">
                            <label for="checkout_billing_tax" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">
                                Adószám <span class="text-gray-400 font-normal text-[11px]">(Cég esetén)</span>
                            </label>
                            <input wire:model="billing_tax_number" type="text" id="checkout_billing_tax" name="billing_tax_number" placeholder="12345678-1-42"
                                   class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:outline-none transition-all">
                            @error('billing_tax_number')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- billing_zip -->
                        <div class="lg:col-span-1">
                            <label for="checkout_billing_zip" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">
                                Irányítószám
                            </label>
                            <input wire:model="billing_zip" type="text" id="checkout_billing_zip" name="billing_zip" placeholder="3300" required
                                   class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:outline-none transition-all">
                            @error('billing_zip')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- billing_city -->
                        <div class="lg:col-span-1">
                            <label for="checkout_billing_city" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">
                                Város
                            </label>
                            <input wire:model="billing_city" type="text" id="checkout_billing_city" name="billing_city" placeholder="Budapest" required
                                   class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:outline-none transition-all">
                            @error('billing_city')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- billing_address -->
                        <div class="md:col-span-2 lg:col-span-2">
                            <label for="checkout_billing_address" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">
                                Utca, házszám, emelet/ajtó
                            </label>
                            <input wire:model="billing_address" type="text" id="checkout_billing_address" name="billing_address" placeholder="Kossuth Lajos utca 12." required
                                   class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:outline-none transition-all">
                            @error('billing_address')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Másolás Checkbox Kártya -->
                <div class="px-6 sm:px-8 py-4 bg-gray-50/80 border-y border-gray-200">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="same_as_billing" checked class="w-4 h-4 text-red-600 rounded border-gray-300 focus:ring-red-500 shrink-0">
                        <span class="text-xs font-bold text-gray-700">A szállítási adatok megegyeznek a számlázási adatokkal</span>
                    </label>
                </div>

                <!-- 2. SZÁLLÍTÁSI ÉS KAPCSOLATTARTÁSI ADATOK -->
                <div class="p-6 sm:p-8 space-y-6">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                        <h2 class="text-lg font-extrabold text-gray-900 flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-slate-900"></span>
                            Szállítási & Kapcsolattartási Adatok
                        </h2>
                        <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Futárnak szükséges</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
                        <!-- shipping_name -->
                        <div class="md:col-span-2 lg:col-span-4">
                            <label for="checkout_shipping_name" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">
                                Átvevő Neve
                            </label>
                            <input wire:model="shipping_name" type="text" id="checkout_shipping_name" name="shipping_name" placeholder="Gipsz Jakab" required
                                   class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:outline-none transition-all">
                            @error('shipping_name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- shipping_phone -->
                        <div class="md:col-span-1 lg:col-span-2">
                            <label for="checkout_shipping_phone" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">
                                Telefonszám <span class="text-red-500">*</span>
                            </label>
                            <input wire:model="phone" type="tel" id="checkout_shipping_phone" name="shipping_phone" placeholder="+36 30 123 4567" required
                                   class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:outline-none transition-all">
                            @error('checkout_shipping_phone')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- shipping_email -->
                        <div class="md:col-span-1 lg:col-span-2">
                            <label for="checkout_shipping_email" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">
                                E-mail Cím (A visszaigazoláshoz) <span class="text-red-500">*</span>
                            </label>
                            <input wire:model="email" type="email" id="checkout_shipping_email" name="shipping_email" placeholder="gipsz.jakab@example.com" required
                                   class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:outline-none transition-all">
                            @error('email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- shipping_zip -->
                        <div class="lg:col-span-1">
                            <label for="checkout_shipping_zip" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">
                                Irányítószám
                            </label>
                            <input wire:model="shipping_zip" type="text" id="checkout_shipping_zip" name="shipping_zip" placeholder="3300" required
                                   class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:outline-none transition-all">
                            @error('shipping_zip')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- shipping_city -->
                        <div class="lg:col-span-1">
                            <label for="checkout_shipping_city" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">
                                Város
                            </label>
                            <input wire:model="shipping_city" type="text" id="checkout_shipping_city" name="shipping_city" placeholder="Budapest" required
                                   class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:outline-none transition-all">
                            @error('shipping_city')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- shipping_address -->
                        <div class="md:col-span-2 lg:col-span-2">
                            <label for="checkout_shipping_address" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">
                                Utca, házszám, emelet/ajtó
                            </label>
                            <input wire:model="shipping_address" type="text" id="checkout_shipping_address" name="shipping_address" placeholder="Kossuth Lajos utca 12." required
                                   class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:outline-none transition-all">
                            @error('shipping_address')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- shipping_comment -->
                        <div class="md:col-span-2 lg:col-span-4">
                            <label for="checkout_shipping_comment" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">
                                Megjegyzés a futárnak <span class="text-gray-400 font-normal text-[11px]">(opcionális)</span>
                            </label>
                            <textarea wire:model="shipping_comment" id="checkout_shipping_comment" name="shipping_comment" rows="2" placeholder="pl. Csengő 4-es gomb, vagy hagyd a kapunál."
                                      class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:outline-none transition-all resize-y"></textarea>
                        </div>
                    </div>
                </div>

            </div>

            <!-- FOLYTATÁS GOMBOK (VISSZA A KOSÁRHOZ / TOVÁBB AZ ÖSSZEGZÉSHEZ) -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-2">
                <a href="{{ route('cart') }}" class="w-full sm:w-auto px-6 py-3.5 rounded-xl border border-gray-300 text-gray-700 font-bold text-sm hover:bg-gray-100 transition-colors text-center flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Vissza a kosárhoz
                </a>
                
                <button type="submit" class="cursor-pointer w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white font-extrabold px-10 py-3.5 rounded-xl shadow-lg transition-all flex items-center justify-center gap-2 text-sm uppercase tracking-wider">
                    <span>Tovább</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>

        </form>
    </div>
</section>