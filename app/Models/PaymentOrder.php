<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentOrder extends Model
{
    protected $guarded = ['id'];




    protected $casts = [
        'meta'       => 'array',
        'expires_at' => 'datetime',
        'paid_at'    => 'datetime',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    // public function computePayable(): float
    // {
    //     $amt = (float)$this->amount;
    //     if ($this->discount_type === 'flat') {
    //         $amt -= (float)$this->discount_value;
    //     } elseif ($this->discount_type === 'percent') {
    //         $amt -= round($amt * ((float)$this->discount_value) / 100, 2);
    //     }
    //     return max(0, round($amt, 2));
    // }


    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    public function getFinalAmountAttribute(): float
    {
        if (!is_null($this->amount_payable)) {
            return (float) $this->amount_payable;
        }

        // fallback compute from amount + discount fields
        $amt = (float) $this->amount;
        if ($this->discount_type === 'flat') {
            $amt -= (float) $this->discount_value;
        } elseif ($this->discount_type === 'percent') {
            $amt -= round($amt * ((float)$this->discount_value) / 100, 2);
        }
        return max(0, round($amt, 2));
    }





    public static function normalizePhone(string $phone): string
    {
        $digits = preg_replace('/\D+/', '', $phone); // keep digits only
        // Remove leading 0
        $digits = ltrim($digits, '0');
        // If 10-digit, prefix 91
        if (strlen($digits) === 10) return '91' . $digits;
        // If already starts with 91 and 12-digit, accept
        if (strlen($digits) === 12 && str_starts_with($digits, '91')) return $digits;
        // Fallback: trim to 12
        return substr($digits, 0, 12);
    }

    // 💡 Compute final payable (GST inclusive) from amount + discount
    public static function computePayable(float $amount, string $type = 'none', float $value = 0.0): float
    {
        $amount = max($amount, 0);
        $type = $type ?: 'none';
        $value = max($value, 0);

        $final = $amount;
        if ($type === 'flat') {
            $final = max($amount - $value, 0);
        } elseif ($type === 'percent') {
            $final = max($amount - ($amount * $value / 100), 0);
        }
        return round($final, 2);
    }
}
