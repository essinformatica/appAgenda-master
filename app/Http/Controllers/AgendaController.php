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

          if (!is_null($user)) {
               $agenda = \DB::table('agendas')
                    ->join('users', 'users.id', '=', 'agendas.user_id')
                    ->join('horas', 'horas.id', '=', 'agendas.hora_id')
                    ->join('servicos', 'servicos.id', '=', 'agendas.servico_id')
                    ->join('profissionals', 'profissionals.id', '=', 'agendas.profissional_id')
                    ->where('users.id', '=', $user)
                    // ->where('agendas.data','>=',date("d/m/Y"))
                    ->orderBy('agendas.hora_id', 'asc')
                    ->orderBy('agendas.data')
                    ->select('agendas.id', 'agendas.data', 'users.name', 'profissionals.profissional', 'horas.hora', 'servicos.servico')
                    ->get();
          }

          $hora = null;
          $servico = null;
          $profissional = null;
          return view('agenda/agenda', compact('hora', 'servico', 'agenda', 'profissional'));
     }
     public function VisualizarTodosAgendamentos()
     {

          $agenda = \DB::table('agendas')
               ->join('users', 'users.id', '=', 'agendas.user_id')
               ->join('horas', 'horas.id', '=', 'agendas.hora_id')
               ->join('servicos', 'servicos.id', '=', 'agendas.servico_id')
               ->join('profissionals', 'profissionals.id', '=', 'agendas.profissional_id')
               ->orderBy('agendas.data')
               ->orderBy('agendas.hora_id', 'asc')
               ->select('agendas.id', 'agendas.data', 'users.name', 'profissionals.profissional', 'horas.hora', 'servicos.servico')
               ->get();
          //dd($agenda);

          return view('agenda/todosAgendamentos', compact('agenda'));
     }

     public function VisualizarTodosFiltros(Request $request)
     {

          $data = date('d/m/Y', strtotime($request->input('dData')));
          $agenda = \DB::table('agendas')
               ->join('users', 'users.id', '=', 'agendas.user_id')
               ->join('horas', 'horas.id', '=', 'agendas.hora_id')
               ->join('servicos', 'servicos.id', '=', 'agendas.servico_id')
               ->join('profissionals', 'profissionals.id', '=', 'agendas.profissional_id')
               ->where('agendas.data', '=', $data)
               ->orderBy('agendas.data')
               ->orderBy('agendas.hora_id', 'asc')
               ->select('agendas.id', 'agendas.data', 'users.name', 'profissionals.profissional', 'horas.hora', 'servicos.servico')
               ->get();
          //dd($agenda);

          return view('agenda/todosAgendamentos', compact('agenda'));
     }
     public function SalvarAgenda()
     {
          $user = $user = Auth::user()->id;
          $email = Auth::user()->email;
          $data = $_POST['dData'];
          $hora = $_POST['idHora']; //$request->hora;
          $profissional = $_POST['idProfissional']; //$request->profissional;
          $servico = $_POST['idServico']; //$request->input('serv');
          $agenda =  new \App\Agenda;
          $agenda->user_id = $user;
          $agenda->profissional_id = $profissional;
          $agenda->data = $data;
          $agenda->hora_id = $hora;
          $agenda->servico_id = $servico;
          $agenda->save();

          /* $agenda = \DB::table('agendas')
               ->join('users', 'users.id', '=', 'agendas.user_id')
               ->join('horas', 'horas.id', '=', 'agendas.hora_id')
               ->join('servicos', 'servicos.id', '=', 'agendas.servico_id')
               ->join('profissionals', 'profissionals.id', '=', 'agendas.profissional_id')
               ->where('users.id', '=', $user)
               ->where('agendas.data', '>=', $data)
               ->orderBy('agendas.hora_id', 'asc')
               ->orderBy('agendas.data')
               ->select('agendas.id', 'agendas.data', 'users.name', 'profissionals.profissional', 'horas.hora', 'servicos.servico')

               ->get();*/
          $hora = \DB::table('horas')
               ->where('horas.id', '=', $hora)
               ->Select('hora')
               ->get();
          $servico = \DB::table('servicos')
               ->where('servicos.id', '=', $servico)
               ->Select('servico')
               ->get();
          $profissional = \DB::table('profissionals')
               ->where('profissionals.id', '=', $profissional)
               ->Select('profissional')
               ->get();

          $headers =  'MIME-Version: 1.0' . "\r\n";
          $headers .= 'From: REJANE<rejanecamara4@gmail.com>' . "\r\n";
          $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
          $returnPath = "-f rejanecamara4@gmail.com";
          $mensagem = "<hr><span style='color:green;font-size:16px'>Informações sobre seu Agendamento</span></hr><br><br>Olá " . Auth::user()->name . ' <br>Seu agendamento foi realizado com sucesso!' . '<br> Data: ' . $data . '<br> Hora: ' . $hora[0]->hora . '<br> Profissional: ' . $profissional[0]->profissional . '<br> Serviço:' . $servico[0]->servico . '<br><br><br>Agradecemos o contato.';
          mail($email, 'Agendamento', $mensagem, $headers, $returnPath);

          $hora = null;
          $servico = null;
          $profissional = null;
          return redirect()->route('agenda.index');
     }

     public function PopulaHora()
     {
          $_GET['data'];
          $user = Auth::user()->id;

          $hora = \DB::table('horas')
               ->whereNotIn('id', function ($query) {
                    $query->select('hora_id')
                         ->from('agendas')
                         ->where('agendas.data', '=', $_GET['data']);
               })
               ->orderby('hora')
               ->get();

          $servico = \App\Servico::all();



          return   response()->json([$hora, $servico]);
     }
     public function PopulaProfissional()
     {
          $id = $_GET['id'];
          $profissional = \App\Profissional::where('servico_id', $id)->get();
          // return redirect()->route('agenda.index');
          return response()->json([$profissional]);
     }
     public function ExcluiAgenda()
     {
          $id = $_GET['id'];
          $agendaUser = \DB::table('agendas')
               ->join('users', 'users.id', '=', 'agendas.user_id')
               ->join('horas', 'horas.id', '=', 'agendas.hora_id')
               ->join('servicos', 'servicos.id', '=', 'agendas.servico_id')
               ->join('profissionals', 'profissionals.id', '=', 'agendas.profissional_id')
               ->where('agendas.id', '=', $id)
               ->select('agendas.id', 'agendas.data', 'users.name', 'profissionals.profissional', 'horas.hora', 'servicos.servico')
               ->get();


          $agenda = \App\Agenda::find($id);
          $agenda->delete();
          \Session::flash('flash_message', [
               'msg' => "Cliente Deletado com sucesso!",
               'class' => "alert-success"
          ]);

          $email = Auth::user()->email;
          $headers =  'MIME-Version: 1.0' . "\r\n";
          $headers .= 'From: REJANE<rejanecamara4@gmail.com>' . "\r\n";
          $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
          $returnPath = "-f rejanecamara4@gmail.com";
          $mensagem = "<hr><span style='color:red;font-size:16px'>Informações sobre seu Agendamento</span></hr><br><br>Olá " . Auth::user()->name . ' <br>Seu agendamento foi desmarcado com sucesso!' . '<br> Data: ' . $agendaUser[0]->data . '<br> Hora: ' . $agendaUser[0]->hora . '<br> Profissional: ' . $agendaUser[0]->profissional . '<br> Serviço:' . $agendaUser[0]->servico . '<br><br><br> Qualquer dúvida, favor entrar em contato.';
          mail($email, 'Agendamento', $mensagem, $headers, $returnPath);
          return redirect()->route('agenda.index');
     }
}
