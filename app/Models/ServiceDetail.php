<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceDetail extends Model
{
    //
    protected $guarded = ['id'];


    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id');
    }

    public function seo()
    {
        return $this->hasOne(Seo::class);
    }
}
