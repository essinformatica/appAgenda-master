<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hora extends Model
{
    public function agenda()
    {
    	return $this->hasMany('App\Agenda');
    }
   
}
