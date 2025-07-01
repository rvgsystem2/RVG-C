<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    //
    protected $guarded = ['id'];

   public function serviceDetails()
{
    return $this->hasMany(ServiceDetail::class, 'category_id');
}

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
