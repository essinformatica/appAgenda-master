@extends('layouts.app_page')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="card">

        <ol class="breadcrumb panel-heading">
          <li>
            <a href="#">Serviço / </a>
          </li>
          <li class="active"> Adicionar</li>
        </ol>
        <div class="card-body">
          <form action="{{route('servico.salvar')}}" method="post">
            {{csrf_field()}}
            <div class="form-group {{$errors->has('servico') ? 'has-error':''}}">
              <label for=servico>Serviço</label>
              <input type="text" name="servico" class="form-control" placeholder="Digite o Serviço">
              @if($errors->has('servico'))
              <span class='help-block'>
                <strong>{{$errors->first('servico')}}</strong>
              </span>
              @endif
            </div>
            <button class="btn btn-info">Adicionar</button>
          </form>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection