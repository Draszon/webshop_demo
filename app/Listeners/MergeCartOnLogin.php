<?php

namespace App\Listeners;

use App\Services\CartService;

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
