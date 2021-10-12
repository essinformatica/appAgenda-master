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
        // dd($profissional);
        return view('\profissional\adicionarProfissional');
    }
}
