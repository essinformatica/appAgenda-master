@extends('layouts.app_page')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="card">

        <ol class="breadcrumb panel-heading">
          <li>
            <a href="#">Hora / </a>
          </li>
          <li class="active"> Adicionar</li>
        </ol>
        <div class="card-body">
          <form action="{{route('hora.salvar')}}" method="POST">
            {{csrf_field()}}
            <div class="form-group {{$errors->has('hora') ? 'has-error':''}}">
              <label for=hora>Hora</label>
              <input type="text" name="hora" class="form-control" placeholder="Digite a hora">
              @if($errors->has('hora'))
              <span class='help-block'>
                <strong>{{$errors->first('hora')}}</strong>
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
<script>
  $('.salvar').click(function() {
    var hora = $('#hora').val();
    $.ajax({
      type: 'POST',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "SalvarHora",
      Data: {
        _token: $('meta[name="csrf-token"]').attr('content'),
        hora: hora
      },
      success: function(data) {
        alert("Hora Incluida com sucesso.");
        $(".modal").hide();
        //location.reload();
      },
      error: function(xhr, ajaxOptions, thrownError) {
        alert("Erro: " + xhr.status + " " + thrownError);
        jQuery(".modal").hide();

      }

    });

  });
</script>
@endsection