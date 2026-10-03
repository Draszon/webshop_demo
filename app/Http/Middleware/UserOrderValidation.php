<?php

namespace App\Http\Middleware;

use App\Models\Order;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserOrderValidation
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $orderNumber = $request->route('order');

        if (!session('just_ordered') && session('just_ordered') !== $orderNumber) {
            return redirect()->route('home');
        }

        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', $request->user()->id)
            ->first();
        
        if (!$order) {
            abort(403, 'Helytelen azonosító');
        }

        return $next($request);
    }
}
