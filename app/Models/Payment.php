<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'transaction_type',
        'fund_type',
        'amount',
        'name',
        'contact',
        'address',
        'email',
        'op_number',
        'payment_mode',
        'meta',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'meta' => 'array',
    ];
}
