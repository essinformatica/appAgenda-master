<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class AgendaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    public function messages()
    {
        return [
            'hora.not_in'=>'Escolha um horário',
            'serv.not_in'=>'Escolha um Servico',
            'profissional.not_in'=>'Escolha um Profissional'
           ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'hora'=>'required|not_in:Selecione a hora',
            'serv'=>'required|not_in:Selecione Servico',
            'profissional'=>'required|not_in:Selecione Profissional'
        ];
    }
}
