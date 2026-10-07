<?php

namespace App\Http\Middleware;

use App\Services\CartService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

use function PHPUnit\Framework\isEmpty;

class EnsureCheckoutIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
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
        } else {
            $cart = session('cart');
            $userData = collect(session('userData', []));
            $shippingAndPayment = session('checkout', []);

            $requiredFields = [
                'billing_name', 'billing_zip', 'billing_city', 'billing_address',
                'shipping_name', 'phone', 'email', 'shipping_zip', 'shipping_city', 'shipping_address'
            ];

            $isValidUserData = collect($requiredFields)->every(function ($field) use ($userData) {
                return $userData->has($field) && filled($userData->get($field));
            });

            $isValidShipping = filled($shippingAndPayment['shipping_method_id'] ?? null)
                && filled($shippingAndPayment['payment_method_id'] ?? null);

            if (empty($cart)) {
                return redirect()->route('filter');
            }

            if ($request->route()->getName() === 'paymentAndShipping'|| $request->route()->getName() === 'checkout') {
                if (!$isValidUserData) {
                    return redirect()->route('dataCheck');
                }
            }

            if ($request->route()->getName() === 'checkout') {
                if (!$isValidUserData && !$isValidShipping) {
                    return redirect()->route('paymentAndShipping');
                }
            }
        }

        return $next($request);
    }
}
