@extends('layouts.app_page')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <ol class="breadcrumb panel-heading">
          <li class="Active">Profissionais</li>
        </ol>

        <div class="card-body">
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif

          <p>
            <a class="btn btn-info" href="#">Adicionar</a>
          </p>
          <div>
            <form action="#" method="get">
              <p><input type="text" name="txtBuscar" class="form-control {{ $errors->has('email') ? 'alert-danger' : ''}}" placeholder="Digite um nome para pesquisa">
              </p>

              @if($errors->has('txtBuscar'))
              <span class='help-block'>
                <strong>{{$errors->first('txtBuscar')}}</strong>
              </span>
              @endif
              <p><button class="btn btn-info">Pesquisar</button></p>
            </form>
          </div>


          <table class="table table-hover table-bordered">
            <thead>
              <tr>
                <td scope="col"><b>#</b></td>
                <td scope="col"><b>Serviço</b></td>
                <td scope="col"><b>Profissional</b></td>
                <td scope="col"><b>ENDEREÇO</b></td>
                <td scope="col"><b>BAIRRO</b></td>
                <td scope="col"><b>CIDADE</b></td>
                <td scope="col"><b>TELEFONE</b></td>
                <td scope="col"><b>RG</b></td>
                <td scope="col"><b>CPF</b></td>
                <td scope="col" colspan="3" style="width:30px; "><b>AÇÃO</b></td>
              </tr>
            </thead>
            <tbody>
              @foreach($profissional as $cli)

              <tr>
                <th scope="row">{{$cli->id}}</th>
                <td>{{$cli->servico_id}}</td>
                <td>{{$cli->profissional}}</td>
                <td>{{$cli->endereco}}</td>
                <td>{{$cli->bairro}}</td>
                <td>{{$cli->cidade}}</td>
                <td>{{$cli->telefone}}</td>
                <td>{{$cli->rg}}</td>
                <td>{{$cli->cpf}}</td>
                <td data-title="'Handled'" style="width:30px; "><a class="btn btn-default" href="#">Detalhe</a></td>
                <td data-title="'Handled'" style="width:30px; "><a class="btn btn-default" href="#">Editar</a></td>
                <td data-title="'Handled'" style="width:30px; "><a class="btn btn-danger" href="javascript:(confirm('Deseja deletar ?')?window.location.href='#':false)">Deletar</a></td>
              </tr>
              @endforeach

            </tbody>
          </table>
          <div align='center'>
            {!! $profissional->links() !!}
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection