<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'user_id',
    'order_number',
    'total_price',
    'status',
    'payment_status',

    // Kapcsolattartó
    'customer_name',
    'customer_email',
    'customer_phone',

    // Számlázási snapshot
    'billing_name',
    'billing_tax_number',
    'billing_zip',
    'billing_city',
    'billing_address',
    'payment_method',

    // Szállítási snapshot
    'shipping_name',
    'shipping_zip',
    'shipping_city',
    'shipping_address',
    'shipping_comment',
    'shipping_method',
    'shipping_cost',
])]
class Order extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
