<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'invoice_number',
        'date',
        'payment_method',
        'total_items',
        'total_amount',
        'items'
    ];

    protected $casts = [
        'date' => 'datetime',
        'items' => 'array'
    ];
}
