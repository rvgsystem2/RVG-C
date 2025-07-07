<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $guarded = ['id'];

    public function career(){
        return $this->belongsTo(Career::class, 'career_id');
    }
}
