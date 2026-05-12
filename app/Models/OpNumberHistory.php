<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpNumberHistory extends Model
{
    protected $table = 'op_number_histories';

    protected $fillable = [
        'payment_id',
        'fund_type',
        'op_number',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
