<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
public function stations()
    {
        return $this->belongsToMany('App\Station');
    }
}
