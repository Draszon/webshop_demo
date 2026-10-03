<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Services\CartService;
use App\Models\ShippingMethod;
use App\Models\PaymentMethod;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\CartItem;

/**
 * Livewire komponens a rendelés adatainak ellenőrzéséhez és véglegesítéséhez.
 */
new #[Layout('layouts::site'), Title('GumiPro - Összegzés')] class extends Component
{
    public $user;
    public $cartItems;
    public $payment;
    public $shipping;

    /**
     * Betölti a bejelentkezett felhasználót, a kosártartalmat,
     * valamint a munkamenetben kiválasztott szállítási és fizetési módot.
     */
    public function mount(CartService $cartService)
    {
        $this->user = Auth::user();
        $this->cartItems = $cartService->getCartItems();
        $this->shipping = ShippingMethod::find(session('checkout.shipping_method_id'));
        $this->payment = PaymentMethod::find(session('checkout.payment_method_id'));

        if (!$this->shipping || !$this->payment) {
            session()->forget('checkout');
            $this->redirectRoute('paymentAndShipping');
            return;
        }
    }

    /**
     * Összeadja a kosárban szereplő abroncsok árát a mennyiségekkel együtt.
     */
    public function sumPrice(): int
    {
        return app(CartService::class)->getCartItems()->sum(function ($item) {
            return $item->tire->price * $item->quantity;
        });
    }

    /**
     * Egyedi, ORD- előtagú rendelési azonosítót generál.
     */
    public function orderNumber(): string
    {
        do {
            $orderNum = 'ORD-' . strtoupper(Str::random(8));
        } while (Order::where('order_number', $orderNum)->exists());

        return $orderNum;
    }

    /**
     * Kiszámítja a termékek, a szállítás és a fizetési mód együttes díját.
     */
    public function totalPrice()
    {
        $total = $this->sumPrice() + $this->shipping->cost + $this->payment->cost;
        return $total;
    }

    /**
     * Tranzakcióban létrehozza a rendelést és a tételeit, majd kiüríti a kosarat.
     * Hiba esetén üzenetet tesz a munkamenetbe, és visszairányít a kosárhoz.
     */
    public function placeOrder()
    {
        try {
            // A tranzakció biztosítja, hogy a rendelés és a tételei együtt kerüljenek mentésre.
            $order = DB::transaction(function() {
                // Zároljuk a kosártételeket, hogy párhuzamos rendelés ne dolgozza fel őket újra.
                $cartItems = CartItem::where('user_id', auth()->id())
                    ->lockForUpdate()
                    ->get();

                $orderNum = $this->orderNumber();

                // Üres kosárból vagy hiányos checkout-adatokkal nem véglegesíthető a rendelés.
                if ($cartItems->isEmpty()) {
                    throw new \Exception('A kosár üres, vagy a rendelés már feldolgozás alatt áll!');
                }

                if (!session()->has('checkout.shipping_method_id') || !session()->has('checkout.payment_method_id')) {
                    throw new \Exception('A szállítási és fizetési adatok hiányoznak!');
                }

                $order = Order::create([
                    'user_id' => auth()->id(),
                    'order_number' => $orderNum,
                    'total_price'  => $this->totalPrice(),
                    'status' => 'Folyamatban',
                    'payment_status' => 'Nincs fizetve',
                    'customer_name' => auth()->user()->name,
                    'customer_email' => auth()->user()->email,
                    'customer_phone' => auth()->user()->phone,
                    'billing_name' => auth()->user()->billing_name,
                    'billing_tax_number' => auth()->user()->billing_tax_number,
                    'billing_zip' => auth()->user()->billing_zip,
                    'billing_city' => auth()->user()->billing_city,
                    'billing_address' => auth()->user()->billing_address,
                    'shipping_name' => auth()->user()->shipping_name,
                    'shipping_address' => auth()->user()->shipping_address,
                    'shipping_method' => $this->shipping->id,
                    'payment_method' => $this->payment->id,
                    'shipping_comment' => auth()->user()->shipping_comment,
                    'shipping_city' => auth()->user()->shipping_city,
                    'shipping_zip' => auth()->user()->shipping_zip,
                    'shipping_cost' => $this->shipping->cost,
                ]);

                // A rendelési tételek elmentik a terméket, a mennyiséget és az aktuális egységárat.
                foreach ($cartItems as $item) {
                    $order->orderItems()->create([
                        'tire_id' => $item->tire_id,
                        'quantity' => $item->quantity,
                        'unit_price' => $item->tire?->price ?? 0,
                    ]);
                }

                // Sikeres rendelés után töröljük a kosártételeket és a checkout munkamenet-adatait.
                CartItem::where('user_id', auth()->id())->delete();
                session()->forget('checkout');

                return $order;
            });

            session()->put('just_ordered', $order->order_number);
            return redirect()->route('thanks', ['order' => $order->order_number]);

        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());

            return redirect()->route('cart');
        }
    }
};
?>

<!-- ==================== AUTÓGUMI WEBSHOP - 3. LÉPÉS: RENDELÉS ÖSSZEGZÉSE ==================== -->
<section class="bg-gray-50 min-h-screen py-8 px-4 sm:px-6 lg:px-8 text-gray-800">
    <div class="max-w-4xl mx-auto space-y-8">
        
        <!-- Oldal Fejléc -->
        <div class="text-center">
            <span class="text-xs font-extrabold uppercase tracking-widest text-red-600 bg-red-50 px-3 py-1 rounded-full border border-red-100 inline-block mb-2">
                3. Lépés
            </span>
            <h1 class="text-2xl sm:text-3xl font-black text-gray-900 uppercase tracking-tight">Rendelés Összegzése</h1>
            <p class="text-sm text-gray-500 mt-1 max-w-lg mx-auto">
                Kérjük, ellenőrizd az adataidat és a megrendelni kívánt abroncsokat a véglegesítés előtt.
            </p>
        </div>

        <form wire:submit="placeOrder" class="space-y-6">
            
            <!-- 1. MEGADOTT ADATOK ÁTTEKINTÉSE -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden divide-y divide-gray-100">
                
                <!-- Számlázási Adatok -->
                <div class="p-6 sm:p-8 flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-600"></span>
                            <h3 class="text-xs font-extrabold text-gray-400 uppercase tracking-wider">Számlázási Adatok</h3>
                        </div>
                        <p class="text-base font-bold text-gray-900">{{ $user->billing_name }}</p>
                        <p class="text-sm text-gray-600">{{ $user->billing_address }}</p>
                        <p class="text-sm text-gray-600">{{ $user->billing_zip }} {{ $user->billing_city }}, Magyarország</p>
                        <p class="text-xs text-gray-400 mt-1">Adószám: <span class="text-gray-600 font-medium">{{ $user->billing_tax_number }}</span></p>
                    </div>
                    <a href="{{ route('dataCheck') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 px-3 py-2 rounded-lg transition-colors self-start">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                        Módosítás
                    </a>
                </div>

                <!-- Szállítási & Kapcsolattartási Adatok -->
                <div class="p-6 sm:p-8 flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-slate-900"></span>
                            <h3 class="text-xs font-extrabold text-gray-400 uppercase tracking-wider">Szállítás & Kapcsolat</h3>
                        </div>
                        <p class="text-base font-bold text-gray-900">{{ $user->shipping_name }}</p>
                        <p class="text-sm text-gray-600">{{ $user->shipping_address }}</p>
                        <p class="text-sm text-gray-600">{{ $user->shipping_zip }} {{ $user->shipping_city }}, Magyarország</p>
                        <div class="pt-2 text-xs text-gray-500 space-y-0.5">
                            <p><strong>Tel:</strong> {{ $user->phone }}</p>
                            <p><strong>E-mail:</strong> {{ $user->email }}</p>
                            <p class="italic text-gray-400 pt-1">{{ $user->shipping_comment }}</p>
                        </div>
                    </div>
                    <a href="{{ route('dataCheck') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 px-3 py-2 rounded-lg transition-colors self-start">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                        Módosítás
                    </a>
                </div>

                <!-- Szállítási és Fizetési Mód -->
                <div class="p-6 sm:p-8 grid grid-cols-1 sm:grid-cols-2 gap-6 bg-gray-50/50">
                    <div>
                        <h4 class="text-xs font-extrabold text-gray-400 uppercase tracking-wider mb-1">Választott Szállítás</h4>
                        <p class="text-sm font-bold text-gray-900 flex items-center gap-2">
                            <span>{{ $shipping->name }}</span>
                        </p>
                    </div>
                    <div>
                        <h4 class="text-xs font-extrabold text-gray-400 uppercase tracking-wider mb-1">Választott Fizetés</h4>
                        <p class="text-sm font-bold text-gray-900">{{ $payment->name }}</p>
                    </div>
                </div>

            </div>

            <!-- 2. MEGRENDELT ABRONCSOK LISTÁJA -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6 sm:p-8 border-b border-gray-100 flex items-center justify-between">
                    <h2 class="text-lg font-black text-gray-900 uppercase tracking-wide">
                        Kosár tartalma
                    </h2>
                    <a href="{{ route('cart') }}" class="text-xs font-bold text-red-600 hover:underline">Kosár szerkesztése</a>
                </div>

                <div class="divide-y divide-gray-100">
                    <!-- 1. Gumi Tétel -->
                    @foreach ($cartItems as $cartItem)
                        <div class="p-6 flex items-center gap-4 sm:gap-6">
                            <div class="w-16 h-16 bg-gray-100 rounded-xl shrink-0 flex items-center justify-center font-bold text-[10px] text-gray-400 border border-gray-200 text-center leading-tight">
                                GUMI<br>KÉP
                            </div>
                            <div class="flex-1 min-w-0">
                                <span class="text-[10px] font-black uppercase bg-gray-100 text-gray-700 px-2 py-0.5 rounded tracking-wider">{{ $cartItem->tire->season }}</span>
                                <h3 class="text-sm sm:text-base font-bold text-gray-900 truncate mt-1">{{ $cartItem->tire->pattern }}</h3>
                                <p class="text-xs font-semibold text-gray-600 mt-0.5">{{ $cartItem->tire->width }}/{{ $cartItem->tire->profile }} R{{ $cartItem->tire->diameter }} {{ $cartItem->tire->load_index }}{{ $cartItem->tire->speed_index }}</p>
                                <p class="text-xs text-gray-600 font-semibold mt-1 sm:hidden"></p>
                            </div>
                            <div class="hidden sm:block text-right">
                                <span class="text-xs text-gray-400 block">{{ $cartItem->quantity }} db × {{ number_format($cartItem->tire->price, 0, ' ', ' ') }} Ft</span>
                                <span class="text-base font-extrabold text-gray-900">{{ number_format($cartItem->tire->price * $cartItem->quantity, 0, ',', ' ') }} Ft</span>
                            </div>
                        </div>
                    @endforeach
                    
                </div>
            </div>

            <!-- 3. PÉNZÜGYI ÖSSZEGZÉS & JÓVÁHAGYÁS -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8 space-y-6">
                
                <div class="space-y-3 text-sm max-w-sm ml-auto">
                    <div class="flex justify-between text-gray-600">
                        <span>Abroncsok részösszege:</span>
                        <span class="font-semibold text-gray-900">{{ number_format($this->sumPrice(), 0, ' ', ' ') }} Ft</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Környezetvédelmi termékdíj:</span>
                        <span class="font-semibold text-gray-900">Tartalmazza</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Szállítási díj:</span>
                        <span class="font-semibold text-gray-900">+ {{ number_format($shipping->cost, 0, ' ', ' ') }} Ft</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>{{ $payment->name }}:</span>
                        <span class="font-semibold text-gray-900">+ {{ number_format($payment->cost, 0, ' ', ' ') }} Ft</span>
                    </div>
                    <div class="flex justify-between text-lg sm:text-xl font-black text-gray-900 pt-4 border-t border-gray-200">
                        <span>Fizetendő végösszeg:</span>
                        <span class="text-red-600">{{ number_format($shipping->cost + $payment->cost + $this->sumPrice(), 0, ' ', ' ') }} Ft</span>
                    </div>
                </div>

                <!-- ÁSZF & Jogi Nyilatkozat Checkbox -->
                <div class="pt-4 border-t border-gray-100">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="accept_terms" required class="w-5 h-5 mt-0.5 text-red-600 rounded border-gray-300 focus:ring-red-500 shrink-0">
                        <span class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                            Elolvastam és elfogadom az <a href="#" class="text-red-600 underline font-bold">Általános Szerződési Feltételeket (ÁSZF)</a>, valamint hozzájárulok adataim kezeléséhez az <a href="#" class="text-red-600 underline font-bold">Adatkezelési Tájékoztatóban</a> foglaltak szerint. <span class="text-red-500">*</span>
                        </span>
                    </label>
                </div>

                <!-- AKCIÓGOMBOK -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4">
                    <a href="{{ route('paymentAndShipping') }}" class="w-full sm:w-auto px-6 py-3.5 rounded-xl border border-gray-300 text-gray-700 font-bold text-sm hover:bg-gray-100 transition-colors text-center flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Vissza az szállításhoz
                    </a>
                    
                    <button type="submit" class="w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white font-extrabold px-12 py-4 rounded-xl shadow-xl transition-all flex items-center justify-center gap-3 text-base uppercase tracking-wider">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Rendelés Véglegesítése</span>
                    </button>
                </div>

            </div>

        </form>
    </div>
</section>