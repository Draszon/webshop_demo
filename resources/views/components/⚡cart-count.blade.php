<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\CartItem;

new class extends Component
{
    public int $cartCount = 0;

    public function mount()
    {
        $this->updateCartCount();
    }

    #[On('cart-update')]
    public function updateCartCount(): void
    {
        if (!Auth::check()) {
            $this->cartCount = array_sum(session('cart', []));
        } else {
            $this->cartCount = CartItem::where('user_id', Auth::id())->sum('quantity');
        }
    }
};
?>

<a href="{{ route('cart') }}" class="p-2 sm:p-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl transition-colors relative flex items-center gap-2 font-bold text-xs sm:text-sm shadow-md">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
    </svg>
    <span class="hidden sm:inline">Kosár</span>
    <span class="bg-slate-900 text-white text-[10px] sm:text-xs w-4 h-4 sm:w-5 sm:h-5 rounded-full flex items-center justify-center font-extrabold border border-slate-700">
        {{ $cartCount }}
    </span>
</a>