@extends('layouts.app_page')
@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="card">
        <input type="button" class="abrir btn btn-info" style="font-weight: bold;" value="Horários Agendados">
      </div>
      <div class="card">
        <div class="card-header" align="center"><b>AGENDAMENTO</b></div>
        @if (session('status'))
        <div class="alert alert-success" role="alert">
          {{ session('status') }}
        </div>
        @endif
        <div class="card-body">
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif

          <div align="center" id="calendario" class="date">

          </div>

          <div id="myModal" class="form-control modal">
            <div id="reservar" class="modal-content">

              <span class="close">&times;</span>
              <span style="text-align: center"><b>Agendar Horário</b></span>
              <form>
                {{ csrf_field() }}
                <input type="hidden" name="dData" class="dData form-control">
                <input type="hidden" name="user" value="{{Auth::user()->id}}">
                <p></p>
                <b>Data:</b>
                <span id="data"></span>
                <p></p>
                <b>Horário disponível:</b>
                <select name='hora' class="form-control hora {{$errors->has('nome')?'has-error':''}}" required autofocus>
                  <option value="0">-Selecione-</option>
                  @if($hora!=null)
                  @foreach($hora as $h)
                  <option value="{{$h->id}}">{{$h->hora}}</option>
                  @endforeach
                  @endif
                  @if($errors->has('nome'))
                  <span class="help-block">
                    <strong>{{$errors->first('hora')}}
                    </strong>
                  </span>
                  @endif
                </select>


                <b>Serviço:</b>
                <select name='serv' id='serv' class="form-control servico" required autofocus>
                  <option value="0">-Selecione-</option>
                  @if($servico!=null)
                  @foreach($servico as $s)
                  <option value="{{$s->id}}">{{$s->servico}}</option>
                  @endforeach
                  @endif
                </select>
                <b>Profissional:</b>
                <select name='profissional' class="form-control profissional" required autofocus>
                  <option value="0">-Selecione o profissional-</option>
                  @if($profissional!=null)
                  @foreach($profissional as $p)
                  <option value="{{$p->id}}">{{$p->profissional}}</option>
                  @endforeach
                  @endif

                </select>
                <br>
                <input type="button" class="btn btn-info salvar" value="Salvar">
              </form>
            </div>
          </div>
        </div>
      </div>
      <a href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
        {{ __('SAIR') }}
      </a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
    </div>
  </div>
  <div name='myModal' class="modalagendamentos">
    <div name='horarios' class="modal-content-agendamentos">
      <span class="fechar">&times;</span>
      <table name="agendamentos" class="table table-hover table-bordered tabela table-sm">
        <tr></tr>
        <th scope="col">NOME</th>
        <th scope="col">HORA</th>
        <th scope="col">SERVIÇO</th>
        <th scope="col">PROFISSIONAL</th>
        <th scope="col">DATA AGENDADA</th>
        <th colspan=3 scope="col">Ações</th>
        </tr>
        @foreach($agenda as $age)
        <tr>
          <td scope="row">{{$age->name}}</td>
          <td>{{$age->hora}}</td>
          <td>{{$age->servico}}</td>
          <td>{{$age->profissional}}</td>
          <td>{{$age->data}}</td>
          <td>
            <div class="col-md-2"><input type="button" id='{{$age->id}}' class="btn btn-danger desmarcar" value='Desmarcar'></div>
    </div>
    </td>
    </tr>
    @endforeach
    </table>

  </div>
</div>

<script>
  jQuery(function($) {
    var arrayMes = new Array(12);
    arrayMes[0] = "01";
    arrayMes[1] = "02";
    arrayMes[2] = "03";
    arrayMes[3] = "04";
    arrayMes[4] = "05";
    arrayMes[5] = "06";
    arrayMes[6] = "07";
    arrayMes[7] = "08";
    arrayMes[8] = "09";
    arrayMes[9] = "10";
    arrayMes[10] = "11";
    arrayMes[11] = "12";
    var nData = new Date();
    var nLen = nData.getDate().toString();
    var nHLen = nData.getHours().toString();
    var dataCompleta = (nLen.length == 1 ? "0" + nData.getDate() : nData.getDate()) + "/" + arrayMes[nData.getMonth()] + "/" + nData.getFullYear();
    var hHora = (nHLen.length == 1 ? "0" + nData.getHours() + ":00" : nData.getHours() + ":00");
    $(".date").datepicker({
      dateFormat: 'dd/mm/yy',
      dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
      dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
      dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
      monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
      monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
      nextText: 'Próximo',
      prevText: 'Anterior',
      minDate: 0,
      onSelect: function(dateText) {
        datax = dateText;
        $(".dData").val(dateText);
        $("#data").text(dateText);
        $.ajax({
          type: 'get',
          url: "PopulaHora",
          data: {
            data: datax,
            id: 3
          },
        }).done(function(data) {
          $('.servico').on('change', function() {
            var valor = $(this).val();

            $.ajax({

              type: 'get',

              url: "PopulaProfissional",
              data: {
                id: valor
              },
              success: function(data) {

                var profissional = '<option value="0">Selecione Profissional</option>'
                /*foreach(var key in data) */
                data[0].forEach((req, i) => {
                  profissional += '<option value="' + req.id + '">' + req.profissional + '</option>'
                });


                $(".profissional").html(profissional).show();
              }

            });
          });

          $.each(data, function(k, v) {
            //display the key and value pair
            var hora = '<option value="0">Selecione a hora</option>'
            var servico = '<option value="0">Selecione Serviço</option>'
            var profissional = '<option value="0">Selecione Profissional</option>'
            for (var key in data) {

              if (key == "0") {
                for (var s in data[key]) {
                  if (datax != data[key][s].data) {
                    if (datax == dataCompleta) {
                      if (data[key][s].hora > hHora)
                        hora += '<option value="' + data[key][s].id + '">' + data[key][s].hora + '</option>';
                      else
                        hora += '<s><option   value="' + data[key][s].id + '" disabled style="color:red;text-decoration:overline;background:#E6E6E6;">' + data[key][s].hora + ' (Indisponível)</option></s>';
                    } else
                      hora += '<option value="' + data[key][s].id + '">' + data[key][s].hora + '</option>';
                  } else
                    hora += '<s><option   value="' + data[key][s].id + '" disabled style="color:red;text-decoration:overline;background:#E6E6E6;">' + data[key][s].hora + ' (Indisponível)</option></s>';
                }
              } else if (key == "1") {
                for (var s in data[key])
                  servico += '<option value="' + data[key][s].id + '">' + data[key][s].servico + '</option>';
              }


            }

            $(".hora").html(hora).show();
            $(".servico").html(servico).show();
            $(".profissional").html(profissional).show();
            $(".modal").show();
          });

        });



        $(".close").click(function() {
          $(".modal").hide();
        });

      }
    }).on("change", function() {
      display("Got change event from field");
    });

    $(".fechar").click(function() {
      $(".modalagendamentos").hide();
    });
    $('.abrir').click(function() {
      $('.modalagendamentos').show();
    });

    //valida combo hora
    $(".hora").on("change", function() {
      if (this.value == "0") {
        $('.hora').css({
          "background": "#E6BABA"
        });
        $('.hora').focus();
      } else {
        $('.hora').css({
          "background": "#FFFFFF"
        });
      }
    });

    //valida combo servico
    $(".servico").on("change", function() {
      if (this.value == "0") {
        $('.servico').css({
          "background": "#E6BABA"
        });
        $('.servico').focus();
      } else {
        $('.servico').css({
          "background": "#FFFFFF"
        });
      }
    });
    //valida combo profissional
    $(".profissional").on("change", function() {
      if (this.value == "0") {
        $('.profissional').css({
          "background": "#E6BABA"
        });
        $('.profissional').focus();
      } else {
        $('.profissional').css({
          "background": "#FFFFFF"
        });
      }

    });
    //clique no botão salvar 
    $('.salvar').click(function() {
      if (ValidaCombo()) {
        return;
      }
      var Hora = $('.hora :selected').val();
      var ser = $('.servico :selected').val();
      var prof = $('.profissional :selected').val();
      var data = $('.dData').val();
      $.ajax({
        type: 'POST',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "SalvarAgenda",
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          idHora: Hora,
          idServico: ser,
          idProfissional: prof,
          dData: data
        },
        success: function(data) {
          alert("Agendado com sucesso! Você receberá um email de confirmação.");
          $(".modal").hide();
          location.reload();
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert("Erro: " + xhr.status + " " + thrownError);
          jQuery(".modal").hide();

        }

      });

    });

    $('.desmarcar').click(function() {
      var Id = $(this).attr('id');
      $.ajax({
        type: 'get',
        url: "ExcluiAgenda",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          id: Id
        },
        success: function(data) {
          alert("Agendamento desmarcado");
          $("#myModal").hide();
          location.reload();
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert("Erro: " + xhr.status + " " + thrownError);
          jQuery("#myModal").hide();

        }

      });

    });
  });

  function ValidaCombo() {
    var retorno = false;
    if ($('.hora :selected').val() == '0') {
      $('.hora').css({
        "background": "#E6BABA"
      });
      $('.hora').focus();
      retorno = true;
    } else {
      $('.hora').css({
        "background": "#FFFFF"
      });
    }
    if ($('.servico :selected').val() == '0') {
      $('.servico').css({
        "background": "#E6BABA"
      });
      $('.servico').focus();
      retorno = true;
    } else {
      $('.servico').css({
        "background": "#FFFFF"
      });
    }
    if ($('.profissional :selected').val() == '0') {
      $('.profissional').css({
        "background": "#E6BABA"
      });
      $('.profissional').focus();
      retorno = true;
    } else {
      $('.profissional').css({
        "background": "#FFFFF"
      });
    }
    return retorno;
  }
</script>

@endsection