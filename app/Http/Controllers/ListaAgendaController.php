<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ListaAgendaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {

        /*$hora = \DB::table('horas')
        ->select('horas.hora','' ,"","","")
        ->get();*/
        $agenda = \DB::table('agendas')
            /*->leftjoin('horas', 'horas.id', '=', 'agendas.hora_id')*/
            ->leftjoin('users', 'users.id', '=', 'agendas.user_id')
            ->leftjoin('servicos', 'servicos.id', '=', 'agendas.servico_id')
            ->leftjoin('profissionals', 'profissionals.id', '=', 'agendas.profissional_id')
             //->where('users.id','=',$user)
            // ->where('agendas.data','>=',date("d/m/Y"))
           /* ->union($hora)*/
           ->rightjoin('horas', function($join)
         {
              $join->on('horas.id','agendas.hora_id')
              
             ->where('agendas.data','=', date('d/m/Y'));
         })
             ->orderBy('horas.hora')
            ->select('horas.hora', 'users.name','servicos.servico','profissionals.profissional','agendas.id')
           
            ->get();
         
        return view('agenda/listaAgenda',compact('agenda'));
    }
    public function getData()
    {
         
        $agenda = \DB::table('agendas')
            /*->leftjoin('horas', 'horas.id', '=', 'agendas.hora_id')*/
            ->leftjoin('users', 'users.id', '=', 'agendas.user_id')
            ->leftjoin('servicos', 'servicos.id', '=', 'agendas.servico_id')
            ->leftjoin('profissionals', 'profissionals.id', '=', 'agendas.profissional_id')
             //->where('users.id','=',$user)
            // ->where('agendas.data','>=',date("d/m/Y"))
           /* ->union($hora)*/
           ->rightjoin('horas', function($join)
         {
              $join->on('horas.id','agendas.hora_id')
              
             ->where('agendas.data','=',$_REQUEST['data']);
         })
             ->orderBy('horas.hora')
            ->select('horas.hora', 'users.name','servicos.servico','profissionals.profissional','agendas.id')
            ->get();
            //dd($agenda);

        return  response()->json([$agenda]);//view('agenda/listaAgenda',compact('agenda'));
    }
}
