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

    public function package(){ return $this->belongsTo(Package::class); }

    public function computePayable(): float
    {
        $amt = (float)$this->amount;
        if ($this->discount_type === 'flat') {
            $amt -= (float)$this->discount_value;
        } elseif ($this->discount_type === 'percent') {
            $amt -= round($amt * ((float)$this->discount_value)/100, 2);
        }
        return max(0, round($amt, 2));
    }


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
        $amt -= round($amt * ((float)$this->discount_value)/100, 2);
    }
    return max(0, round($amt, 2));
}


}
