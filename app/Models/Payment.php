<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OpNumberHistory;

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

    protected static function booted()
    {
        static::creating(function ($payment) {
            if (empty($payment->op_number)) {
                $fundCode = $payment->fund_type;
                $prefix = self::mapPrefix($fundCode);
                $now = now();
                $year = $now->format('Y');
                $month = $now->format('m');

                $like = $prefix . '-' . $year . '-' . $month . '-%';

                $last = self::where('op_number', 'like', $like)
                    ->orderBy('op_number', 'desc')
                    ->first();

                if ($last && preg_match('/-(\d{4})$/', $last->op_number, $m)) {
                    $seq = intval($m[1]) + 1;
                } else {
                    $seq = 1;
                }

                $payment->op_number = sprintf('%s-%s-%s-%04d', $prefix, $year, $month, $seq);
            }
        });
        // After a payment is created, persist the OP number into history for the fund type
        static::created(function ($payment) {
            if (!empty($payment->op_number)) {
                OpNumberHistory::updateOrCreate(
                    ['payment_id' => $payment->id, 'fund_type' => $payment->fund_type],
                    ['op_number' => $payment->op_number]
                );
            }
        });
    }

    public static function mapPrefix(?string $fundCode): string
    {
        $map = [
            'F01' => 'F01',
        ];

        // Default to F01 for any unknown or removed fund codes
        return $map[$fundCode] ?? 'F01';
    }
}
