<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profissional extends Model
{
    public function agendas()
   {
   	return $this->hasMany('App\Agenda');
   }
}
