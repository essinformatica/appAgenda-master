<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
	public function users()
	{
		return $this->belongsTo('App\User');
    }
	
    public function horas()
    {
    	return $this->belongsTo('App\Hora');
    }
    public function servicos()
    {
    	return $this->belongsTo('App\Servico');
    }
    public function profissionals()
    {
    	return $this->belongsTo('App\Profissional');
    }
}
