@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
           <script>
             jQuery(function($){
                 $("#calendario").datepicker({
					showOn: "button",
                    buttonImage: "{{ asset('calendar.gif') }}",
                    buttonImageOnly: true,
					dateFormat: 'dd/mm/yy',
                    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
                    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
                    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
                    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
                    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
                    nextText: 'Próximo',
                    prevText: 'Anterior',
                   // minDate: 0,
                    onSelect: function (dateText) {
                      $('#ndata').val(dateText);
                      $.ajax({
                 type: 'get',
                 url: "getData",
                 data:{data:dateText},
                 success:function(data){
                  $('.agendamentos').html("Aguarde...").show();
                  var tabela = '<table name="agendamentos" class="table table-hover table-bordered tabela table-sm agendamentos">'
                      tabela+= '<tr></tr>'
                      tabela+=  '<th scope="col">HORA</th>'
                      tabela+=	'<th scope="col">NOME</th>'
                      tabela+=	'<th scope="col">SERVIÇO</th>'
                      tabela+=	'<th scope="col">PROFISSIONAL</th>'
                      tabela+=' <th colspan=3 scope="col">AÇÕES</th>'
                      tabela+= '</tr>'
                      
                      for(i in data[0]){
                        var hora = data[0][i].hora==null?"":data[0][i].hora;
                        var name= data[0][i].name==null?"":data[0][i].name;
                        var servico = data[0][i].servico==null?"":data[0][i].servico;
                        var profissional = data[0][i].profissional==null?"":data[0][i].profissional;
                        var id =data[0][i].id==null?0:data[0][i].id;
                        tabela+= '<tr>'
                        tabela+= '<td scope="row">'+hora+'</td>'
                 	      tabela+=  '<td >'+name+'</td>'
                        tabela+= '<td>'+servico+'</td>'
                      	tabela+= '<td>'+profissional+'</td>'
                        tabela+= '<td><div class="col-md-2"><input type="button" id='+id+' class="btn btn-danger desmarcar" value=Desmarcar></div>'
                        tabela+=  '</div></td>'
                        tabela+= '</tr>'
                      }
                      tabela+= '</table>'
                     $('.agendamentos').html(tabela).show();
                 }
})
      }
   });
}); 

setTimeout(function(){
  // $(".agendamentos").load("listaAgenda .agendamentos");
  window.location.reload();
}, 60000);
     </script>
     <form>
     {{ csrf_field() }}
     <input type="hidden" name="ndata" class="ndata form-control">
     </form>
<div style="margin-left: 10px;margin-top:10px"> <input type="text" id="calendario" class="" ></div>
<div name='myModal' >
          	<div name='horarios' class="modal-content-agendamentos">
            <table name="agendamentos" class="table table-hover table-bordered tabela table-sm agendamentos">
              <tr></tr>
                <th scope="col">HORA</th>
            	<th scope="col">NOME</th>
            	<th scope="col">SERVIÇO</th>
            	<th scope="col">PROFISSIONAL</th>
            	<th colspan=3 scope="col">AÇÕES</th>
              </tr>
            	@foreach($agenda as $age)
                 <tr>
                    <td scope="row">{{$age->hora}}</td>
                 	<td >{{$age->name}}</td>
                 	<td>{{$age->servico}}</td>
                 	<td>{{$age->profissional}}</td>
                 	<td><div class="col-md-2"><input type="button" id='{{$age->id}}' class="btn btn-danger desmarcar" value='Desmarcar'></div>
                  </div></td>
                 </tr>
            	@endforeach
            </table>
            </div>
           </div>
@endsection
