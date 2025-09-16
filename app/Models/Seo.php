<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    //
    protected $guarded = ['id'];

    // You can add any additional methods or relationships here if needed
    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }

    public function serviceDetail()
    {
        return $this->belongsTo(ServiceDetail::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    
}
