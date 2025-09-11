<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $guarded = ['id'];


       public function faqs() {
        return $this->hasMany(PackageFaq::class)->orderBy('created_at', 'desc');
    }

   public function media()
{
    
    return $this->hasMany(\App\Models\PackageMedia::class)
                ->orderBy('created_at', 'desc'); 
}


     public function getEffectivePriceAttribute() {
        return $this->sale_price ?? $this->price;
    }



     public function getPriceAmountAttribute(): float
    {
        // price string हो तो भी numeric निकालें
        $base = (float) preg_replace('/[^\d.]/', '', (string)$this->price);
        if (!is_null($this->sale_price)) return (float)$this->sale_price;
        return $base;

}


public function category()
{
    return $this->belongsTo(\App\Models\PackageCategory::class, 'package_category_id');
}


}
