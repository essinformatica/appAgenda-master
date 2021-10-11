<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
class AgendaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {

    	$user = Auth::user()->id;
   
    if(!is_null($user))
    	 {
    	  $agenda = \DB::table('agendas')
            ->join('users', 'users.id', '=', 'agendas.user_id')
            ->join('horas', 'horas.id', '=', 'agendas.hora_id')
            ->join('servicos', 'servicos.id', '=', 'agendas.servico_id')
            ->join('profissionals', 'profissionals.id', '=', 'agendas.profissional_id')
             ->where('users.id','=',$user)
            // ->where('agendas.data','>=',date("d/m/Y"))
             ->orderBy('agendas.hora_id', 'asc')
             ->orderBy('agendas.data')
            ->select('agendas.id','agendas.data', 'users.name','profissionals.profissional', 'horas.hora','servicos.servico')
            ->get();

    	 }

    	 $hora = null;
    	 $servico = null;
         $profissional = null;
         return view('agenda/agenda',compact('hora','servico','agenda','profissional'));
    }
    public function SalvarAgenda()
    {
         $user = $user = Auth::user()->id;
         $email = Auth::user()->email;
         $data = $_POST['dData'];
    	    $hora = $_POST['idHora'];//$request->hora;
    	    $profissional =$_POST['idProfissional']; //$request->profissional;
    	    $servico = $_POST['idServico']; //$request->input('serv');
         $agenda =  new \App\Agenda;
         $agenda->user_id= $user;
         $agenda->profissional_id=$profissional;
         $agenda->data=$data;
         $agenda->hora_id=$hora;
         $agenda->servico_id=$servico;
         $agenda->save(); 
          
    	$agenda = \DB::table('agendas')
            ->join('users', 'users.id', '=', 'agendas.user_id')
            ->join('horas', 'horas.id', '=', 'agendas.hora_id')
            ->join('servicos', 'servicos.id', '=', 'agendas.servico_id')
            ->join('profissionals', 'profissionals.id', '=', 'agendas.profissional_id')
             ->where('users.id','=',$user)
             ->where('agendas.data','>=',$data)
              ->orderBy('agendas.hora_id', 'asc')
              ->orderBy('agendas.data')
            ->select('agendas.id','agendas.data', 'users.name','profissionals.profissional', 'horas.hora','servicos.servico')
           
            ->get();
            $hora = null;
            $servico = null;
            $profissional = null;

            $headers =  'MIME-Version: 1.0' . "\r\n"; 
            $headers .= 'From: REJANE<u162817552@ed-informatica.com>' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
            $returnPath = "-f u162817552@ed-informatica.com";
            mail($email, 'Agendamento', 'Seu agendamento foi realizado com sucesso!',$headers,$returnPath);
         return redirect()->route('agenda.index');
    }
    
    public function PopulaHora()
    {
    	$_GET['data'];
       	$user = Auth::user()->id;
    	
         $hora= \DB::table('horas')
         ->leftjoin('agendas', function($join){
            $join->on('agendas.hora_id','horas.id')
            ->where('agendas.data','=',$_GET['data']);
         })
         
        /* ->leftjoin('agendas', 'agendas.hora_id', '=', 'horas.id')
         ->select('agendas.id','horas.hora')
         ->where('agendas.data','=', $_GET['data'])
         ->orWhere('agendas.data', '=', null)
         ->orderby('horas.hora')*/
       /* ->whereNotIn('id', function($query)
         {
              $query->select('hora_id')
              ->from('agendas')
              ->where('agendas.data','=', $_GET['data']);
         })*/
         ->orderby('horas.hora')
         ->select('horas.id','horas.hora','agendas.user_id','agendas.data')
         
        ->get();
       
        $servico = \App\Servico::all();

        

         return   response()->json([$hora,$servico]);

    }
    public function PopulaProfissional()
    {
       $id = $_GET['id'];
       $profissional = \App\Profissional::where('servico_id',$id)->get();
    
      // return redirect()->route('agenda.index');
      return response()->json([$profissional]);
    }
    public function ExcluiAgenda()
    {
         $id = $_GET['id'];
         $agenda = \App\Agenda::find($id);
         $agenda->delete();
         \Session::flash('flash_message',[
          'msg'=>"Cliente Deletado com sucesso!",
          'class'=>"alert-success"
      ]);
            $email =Auth::user()->email;
            $headers =  'MIME-Version: 1.0' . "\r\n"; 
            $headers .= 'From: REJANE<u162817552@ed-informatica.com>' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
            $returnPath = "-f u162817552@ed-informatica.com";
            mail($email, 'Agendamento', 'Seu agendamento desmarcado!',$headers,$returnPath);
            return redirect()->route('agenda.index');

    }
}
