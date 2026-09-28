<?php

use Livewire\Component;

new class extends Component
{
    // Számlázási mezők
    public $billing_name;
    public $billing_tax_number;
    public $billing_zip;
    public $billing_city;
    public $billing_address;

    // Szállítási mezők
    public $shipping_name;
    public $shipping_zip;
    public $shipping_city;
    public $shipping_address;
    public $phone;

    public function mount()
    {
        $user = Auth::user();

        $this->billing_name = $user->billing_name;
        $this->billing_tax_number = $user->billing_tax_number;
        $this->billing_zip = $user->billing_zip;
        $this->billing_city = $user->billing_city;
        $this->billing_address = $user->billing_address;

        $this->shipping_name = $user->shipping_name;
        $this->shipping_zip = $user->shipping_zip;
        $this->shipping_city = $user->shipping_city;
        $this->shipping_address = $user->shipping_address;
        $this->phone = $user->phone;
    }

    public function updateShipping()
    {
        $user = Auth::user();

        $validated = $this->validate([
            // Kapcsolattartás
            'phone' => ['required', 'string', 'max:20'],

            // Számlázási adatok
            'billing_name' => ['required', 'string', 'max:255'],
            'billing_tax_number' => ['nullable', 'string', 'max:50'],
            'billing_zip' => ['required', 'string', 'max:10'],
            'billing_city' => ['required', 'string', 'max:255'],
            'billing_address' => ['required', 'string', 'max:255'],

            // Szállítási adatok
            'shipping_name' => ['required', 'string', 'max:255'],
            'shipping_zip' => ['required', 'string', 'max:10'],
            'shipping_city' => ['required', 'string', 'max:255'],
            'shipping_address' => ['required', 'string', 'max:255'],
        ], [
            // Egyedi hibaüzenetek
            'phone.required' => 'A telefonszám megadása kötelező.',
            'phone.max' => 'A telefonszám nem lehet hosszabb 20 karakternél.',
            
            'billing_name.required' => 'A számlázási név megadása kötelező.',
            'billing_name.max' => 'A számlázási név nem lehet hosszabb 255 karakternél.',
            'billing_tax_number.max' => 'A adószám nem lehet hosszabb 50 karakternél.',
            'billing_zip.required' => 'A számlázási irányítószám megadása kötelező.',
            'billing_zip.max' => 'A számlázási irányítószám nem lehet hosszabb 10 karakternél.',
            'billing_city.required' => 'A számlázási város megadása kötelező.',
            'billing_city.max' => 'A számlázási város nem lehet hosszabb 255 karakternél.',
            'billing_address.required' => 'A számlázási utca és házszám megadása kötelező.',
            'billing_address.max' => 'A számlázási cím nem lehet hosszabb 255 karakternél.',
            
            'shipping_name.required' => 'A átvevő neve kötelező.',
            'shipping_name.max' => 'A átvevő neve nem lehet hosszabb 255 karakternél.',
            'shipping_zip.required' => 'A szállítási irányítószám megadása kötelező.',
            'shipping_zip.max' => 'A szállítási irányítószám nem lehet hosszabb 10 karakternél.',
            'shipping_city.required' => 'A szállítási város megadása kötelező.',
            'shipping_city.max' => 'A szállítási város nem lehet hosszabb 255 karakternél.',
            'shipping_address.required' => 'A szállítási utca és házszám megadása kötelező.',
            'shipping_address.max' => 'A szállítási cím nem lehet hosszabb 255 karakternél.',
        ]);

        $user->fill($validated);
        $user->save();

        return back()->with('success', 'Sikeres adatfrissítés');
    }
};
?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-pages::settings.layout :heading="__('Szállítás és számlázás')" :subheading="__('Számlázási és szállítási adatok frissítése')">
        <!-- ==================== ADATMÓDOSÍTÓ FORM SZEKCIÓ (EDGE-TO-EDGE, TELJES SZÉLESSÉG MOBILON IS) ==================== -->
        <section class="bg-white text-gray-800 w-full p-0 m-0">
            <form wire:submit="updateShipping" class="w-full bg-white space-y-0">
            
                <div class="p-4 sm:p-8 space-y-8 w-full">
                
                    <!-- 1. SZÁMLÁZÁSI ADATOK BLOCK -->
                    <div class="space-y-5 w-full">
                        <h3 class="text-base sm:text-lg font-extrabold text-gray-900 pb-3 border-b border-gray-200 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-600"></span>
                            Számlázási Adatok
                        </h3>
                        @if (session('success'))
                            <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                                {{ session('success') }}
                            </div>
                        @endif
                    
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 w-full">
                            <!-- billing_name -->
                            <div class="md:col-span-2 lg:col-span-2">
                                <label for="billing_name" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">
                                    Számlázási Név / Cégnév
                                </label>
                                <input wire:model="billing_name" type="text" id="billing_name" name="billing_name" placeholder="pl. Minta Cég Kft. vagy Kovács János"
                                       class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:outline-none transition-all">
                                @error('billing_name')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror                                
                            </div>
                        
                            <!-- billing_tax_number -->
                            <div class="md:col-span-2 lg:col-span-2">
                                <label for="billing_tax_number" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">
                                    Adószám <span class="text-gray-400 font-normal text-[11px]">(Cég esetén kötelező)</span>
                                </label>
                                <input wire:model="billing_tax_number" type="text" id="billing_tax_number" name="billing_tax_number" placeholder="12345678-1-42"
                                       class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:outline-none transition-all">
                                @error('billing_tax_number')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror                                  
                            </div>
                        
                            <!-- billing_zip -->
                            <div class="lg:col-span-1">
                                <label for="billing_zip" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">
                                    Irányítószám
                                </label>
                                <input wire:model="billing_zip" type="text" id="billing_zip" name="billing_zip" placeholder="3300"
                                       class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:outline-none transition-all">
                                @error('zip')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror                                  
                            </div>
                        
                            <!-- billing_city -->
                            <div class="lg:col-span-1">
                                <label for="billing_city" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">
                                    Város
                                </label>
                                <input wire:model="billing_city" type="text" id="billing_city" name="billing_city" placeholder="Eger"
                                       class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:outline-none transition-all">
                                @error('billing_city')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror                                         
                            </div>
                        
                            <!-- billing_address -->
                            <div class="md:col-span-2 lg:col-span-2">
                                <label for="billing_address" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">
                                    Utca, házszám, emelet/ajtó
                                </label>
                                <input wire:model="billing_address" type="text" id="billing_address" name="billing_address" placeholder="Kossuth Lajos utca 12. 2/4."
                                       class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:outline-none transition-all">
                                @error('billing_address')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror                                         
                            </div>
                        </div>
                    </div>
                
                
                    <!-- 2. SZÁLLÍTÁSI ADATOK BLOCK -->
                    <div class="space-y-5 w-full">
                        <h3 class="text-base sm:text-lg font-extrabold text-gray-900 pb-3 border-b border-gray-200 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-slate-900"></span>
                            Szállítási Adatok
                        </h3>
                    
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 w-full">
                            <!-- shipping_name -->
                            <div class="md:col-span-2 lg:col-span-4">
                                <label for="shipping_name" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">
                                    Átvevő Neve
                                </label>
                                <input wire:model="shipping_name" type="text" id="shipping_name" name="shipping_name" placeholder="Kovács János"
                                       class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:outline-none transition-all">
                                @error('shipping_name')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror                                         
                            </div>

                            <!-- shipping_phone -->
                            <div class="md:col-span-1 lg:col-span-2">
                                <label for="shipping_phone" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">
                                    Telefonszám <span class="text-red-500">*</span>
                                </label>
                                <input wire:model="phone" type="tel" id="shipping_phone" name="shipping_phone" placeholder="+36 30 123 4567"
                                       class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:outline-none transition-all">
                                @error('phone')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror                                         
                            </div>
                        
                            <!-- shipping_zip -->
                            <div class="lg:col-span-1">
                                <label for="shipping_zip" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">
                                    Irányítószám
                                </label>
                                <input wire:model="shipping_zip" type="text" id="shipping_zip" name="shipping_zip" placeholder="3300"
                                       class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:outline-none transition-all">
                                @error('shipiing_zip')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror                                         
                            </div>
                        
                            <!-- shipping_city -->
                            <div class="lg:col-span-1">
                                <label for="shipping_city" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">
                                    Város
                                </label>
                                <input wire:model="shipping_city" type="text" id="shipping_city" name="shipping_city" placeholder="Eger"
                                       class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:outline-none transition-all">
                                @error('shipping_city')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror                                         
                            </div>
                        
                            <!-- shipping_address -->
                            <div class="md:col-span-2 lg:col-span-2">
                                <label for="shipping_address" class="block text-xs font-bold text-gray-600 uppercase tracking-wider mb-1">
                                    Utca, házszám, emelet/ajtó
                                </label>
                                <input wire:model="shipping_address" type="text" id="shipping_address" name="shipping_address" placeholder="Kossuth Lajos utca 12. 2/4."
                                       class="w-full bg-white border border-gray-300 rounded-xl px-4 py-3 text-sm text-gray-900 focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:outline-none transition-all">
                                @error('shipping_address')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror                                         
                            </div>
                        </div>
                    </div>
                
                    <!-- MENTÉS GOMB CSOPORT -->
                    <div class="pt-6 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-end gap-3 w-full">
                        <button type="submit" class="w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white font-extrabold px-10 py-3 rounded-xl shadow-md transition-colors flex items-center justify-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Adatok Mentése
                        </button>
                    </div>
                
                </div>
            
            </form>
        </section>
    </x-pages::settings.layout>
</section>