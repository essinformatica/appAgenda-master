<div id="myModal" class="modal">
    <div id="reservar" class="modal-content">
        <span class="close">&times;</span>
        <span style="text-align: center"><b>Agendar Horário</b></span>
        <form action="{{route('agenda.savaragenda')}}"   method="get">

          <input type="hidden"  name="dData" class="dData form-control">
          <input type="hidden" name="user" value="{{Auth::user()->id}}">
          <p></p>
		  <b>Hora:</b>
		     <select name='hora' class="form-control">
		       <option value="0">-Selecione-</option>
		            @foreach($hora as $h)
		                <option value="{{$h->id}}">{{$h->hora}}</option>
		            @endforeach
		                             		                              
		            </select><p></p>

		             <b>Serviço:</b>
		                <select name='servico' class="form-control">
		                   <option value="0">-Selecione-</option>
		                    @foreach($servico as $s)
		                       <option value="{{$s->id}}">{{$s->servico}}</option>
		                    @endforeach
		                </select>
		                 <br>
		    <button class="btn btn-info">Salvar</button>
        </form>
    </div>
</div>
