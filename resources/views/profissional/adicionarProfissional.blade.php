@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="card">
        <ol class="breadcrumb panel-heading">
          <li>
            <a href="{{route('agenda.Profissional')}}">Profissional / </a>
          </li>
          <li class="active"> Adicionar</li>
        </ol>
        <div class="card-body">
          <form action="{{route('profissional.salvar')}}" method="post">
            {{csrf_field()}}
            <div class="form-group {{$errors->has('nome') ? 'has-error':''}}">
              <label for=profissional>Profissional</label>
              <input type="text" name="profissional" class="form-control" placeholder="Nome do Profissional">
              @if($errors->has('profissional'))
              <span class='help-block'>
                <strong>{{$errors->first('profissional')}}</strong>
              </span>
              @endif
            </div>
            <div class="form-group {{$errors->has('endereco') ? 'has-error':''}}">
              <label for=endereco>Endereco</label>
              <input type="text" name="endereco" class="form-control" placeholder="Endereço do Profissional">
              @if($errors->has('endereco'))
              <span class='help-block'>
                <strong>{{$errors->first('endereco')}}</strong>
              </span>
              @endif
            </div>
            <div class="form-group {{$errors->has('bairro') ? 'has-error':''}}">
              <label for=bairro>Bairro</label>
              <input type="text" name="bairro" class="form-control" placeholder="Bairro do Profissional">
              @if($errors->has('bairro'))
              <span class='help-block'>
                <strong>{{$errors->first('bairro')}}</strong>
              </span>
              @endif
            </div>
            <div class="form-group {{$errors->has('cidade') ? 'has-error':''}}">
              <label for=cidade>Cidade</label>
              <input type="text" name="cidade" class="form-control" placeholder="Cidade do Profissional">
              @if($errors->has('cidade'))
              <span class='help-block'>
                <strong>{{$errors->first('cidade')}}</strong>
              </span>
              @endif
            </div>
            <div class="form-group {{$errors->has('telefone') ? 'has-error':''}}">
              <label for=telefone>Telefone</label>
              <input type="text" name="telefone" class="form-control" placeholder="Telefone do Profissional">
              @if($errors->has('telefone'))
              <span class='help-block'>
                <strong>{{$errors->first('telefone')}}</strong>
              </span>
              @endif
            </div>
            <div class="form-group {{$errors->has('rg') ? 'has-error':''}}">
              <label for=rg>RG</label>
              <input type="text" name="rg" class="form-control" placeholder="RG do Profissional">
              @if($errors->has('rg'))
              <span class='help-block'>
                <strong>{{$errors->first('rg')}}</strong>
              </span>
              @endif
            </div>
            <div class="form-group {{$errors->has('cpf') ? 'has-error':''}}">
              <label for=cpf>CPF</label>
              <input type="text" name="cpf" class="form-control" placeholder="CPF do Profissional">
              @if($errors->has('cpf'))
              <span class='help-block'>
                <strong>{{$errors->first('cpf')}}</strong>
              </span>
              @endif
            </div>
            <b>Serviço:</b>
            <select name='serv' id='serv' class="form-control servico" required autofocus>
              <option value="0">-Selecione-</option>
              @if($servico!=null)
              @foreach($servico as $s)
              <option value="{{$s->id}}">{{$s->servico}}</option>
              @endforeach
              @endif
            </select>
            <p></p>
            <button class="btn btn-info">Adicionar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection