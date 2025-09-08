<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentOrder extends Model
{
      protected $fillable = [
        'package_id','name','phone','business_name','amount','currency',
        'razorpay_order_id','razorpay_payment_id','razorpay_signature','status','meta'
    ];

    protected $casts = ['meta' => 'array'];
}
