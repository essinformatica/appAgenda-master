<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
   public function agendas()
   {
   	return $this->hasMany('App\Agenda');
   }
}
