<?php

namespace App\Http\Middleware;

use App\Services\CartService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureCheckoutIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $cart = app(CartService::class)->getCartItems();
        $user = Auth::user();
        $requiredFields = [
            $user->phone,
            $user->billing_name,
            $user->billing_zip,
            $user->billing_city,
            $user->billing_address,
            $user->shipping_name,
            $user->shipping_zip,
            $user->shipping_city,
            $user->shipping_address,
        ];
        
        if ($cart->isEmpty()) {
            return redirect()->route('filter');
        }

        if ($request->route()->getName() === 'paymentAndShipping'|| $request->route()->getName() === 'checkout') {
            if (collect($requiredFields)->contains(fn ($value) => blank($value))) {
                return redirect()->route('dataCheck');
            }
        }
        
        if ($request->route()->getName() === 'checkout') {
            if (!$request->session()->get('checkout.shipping_method_id') && !$request->session()->get('checkout.payment_method_id')) {
                return redirect()->route('paymentAndShipping');
            }
        }

        return $next($request);
    }
}
