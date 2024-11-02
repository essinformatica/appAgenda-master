@extends('layouts.app_page')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">

        <div class="card-header">TODOS AGENDAMENTOS <span class="position:absolute;right:40px;">FILTRO <input type="date" id="dData" /></span><a class="btn btn-info" href="{{route('agenda.VisualizarFiltro')}}">Pesquisar</a> </div>

      </div>
      <div name='horarios'>
        <table name="agendamentos" class="table table-hover table-bordered tabela table-sm">
          <tr></tr>
          <th scope="col">NOME</th>
          <th scope="col">HORA</th>
          <th scope="col">SERVIÇO</th>
          <th scope="col">PROFISSIONAL</th>
          <th scope="col">DATA AGENDADA</th>
          </tr>
          @foreach($agenda as $age)
          <tr>
            <td scope="row">{{$age->name}}</td>
            <td>{{$age->hora}}</td>
            <td>{{$age->servico}}</td>
            <td>{{$age->profissional}}</td>
            <td>{{$age->data}}</td>

          </tr>
          @endforeach
        </table>
      </div>
    </div>
  </div>
</div>
</div>
@endsection