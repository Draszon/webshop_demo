<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'name',
    'cost',
    'is_active',
])]
class ShippingMethod extends Model
{
    //
}
