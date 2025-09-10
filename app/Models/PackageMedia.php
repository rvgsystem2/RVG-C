<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageMedia extends Model
{
    protected $guarded = ['id'];

    
       protected $casts = [
        'media_type' => 'array',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    // Helpers
    public function getTypeAttribute()
    {
        return $this->media_type['type'] ?? null;
    }

    public function getPathAttribute()
    {
        return $this->media_type['path'] ?? null;
    }

    public function getAltAttribute()
    {
        return $this->media_type['alt'] ?? null;
    }

    public function getThumbAttribute()
    {
        return $this->media_type['thumb'] ?? null;
    }
}
