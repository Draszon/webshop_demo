<?php

namespace App\Listeners;

use App\Services\CartService;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MergeCartOnLogin
{
    /**
     * Create the event listener.
     */
    public function __construct(protected CartService $cartService)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(): void
    {
        $this->cartService->mergeSessionCartDatabase();
    }
}
