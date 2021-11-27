<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ServicoController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  public function index()
  {
    $servico = \App\Servico::all();

    return view('\servico\Servico', compact('servico'));
  }
  public function adicionar()
  {
    // dd($servico);
    return view('\servico\adicionarServico');
  }
  public function salvar(Request $request)
  {
    $servico =  new \App\Servico();
    $servico->servico = $request->input('servico');
    $servico->save();
    return view('\servico\adicionarServico');
  }
}
