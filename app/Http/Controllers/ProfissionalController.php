<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfissionalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $profissional = \App\Profissional::all();
        // dd($profissional);
        return view('\profissional\profissional', compact('profissional'));
    }
    public function adicionar()
    {
        $servico = \App\Servico::all();
        return view('agenda\adicionarProfissional', compact('servico'));
    }
    public function salvar(Request $request)
    {
        //dd($request);
        $profissional =  new \App\Profissional();
        $profissional->profissional = $request->input('profissional');
        $profissional->endereco = $request->input('endereco');
        $profissional->bairro = $request->input('bairro');
        $profissional->cidade = $request->input('cidade');
        $profissional->telefone = $request->input('telefone');
        $profissional->telefone = $request->input('telefone');
        $profissional->rg = $request->input('rg');
        $profissional->cpf = $request->input('cpf');
        $profissional->servico_id = $request->input('serv');;
        $profissional->save();
        $servico = \App\Servico::all();
        return redirect()->route('profissional.adicionar', [$servico]);
        //view('\agenda\adicionarProfissional', compact('servico'));
    }
}
