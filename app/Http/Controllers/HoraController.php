<?php

namespace App\Http\Controllers;

use App\Hora;
use Illuminate\Http\Request;

class HoraController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  public function index()
  {
    $hora = \App\Hora::all();
    //dd($hora);
    return view('agenda.adicionarHora', compact('hora'));
  }
  public function adicionar()
  {
    $hora = \App\Hora::all();
    //dd($hora);
    return view('agenda.adicionarHora', compact('hora'));
  }
  public function SalvarHora()
  {
    $idHora = \App\Hora::max('id');

    $hora = new \App\Hora;
    $hora->id = $idHora + 1;
    $hora->hora = $_POST['hora'];
    //dd($hora);
    $hora->Save();

    return redirect()->route('hora.index');
  }
}
