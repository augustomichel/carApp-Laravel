<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateServicoRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->getMethod() == 'PUT') {

            $validacoes = [];
            $validacoes['ser_tipo_servico'] = 'required';
            $validacoes['ser_time_execucao'] = 'required';

            if ($this->input('ser_descricao') != $this->input('ser_descricao_old')) {
                $validacoes['ser_descricao'] = 'required:|unique:servico';
            }

            return $validacoes;
        } else {
            return [
                'ser_descricao'    => 'required:|unique:servico',
                'ser_tipo_servico' => 'required',
                'ser_time_execucao' => 'required',
            ];
        }
    }

    public function messages()
    {
        return [
            'ser_descricao.required' => 'O Campo Descrição é de preenchimento obrigatório!',
            'ser_descricao.unique'   => 'O Campo Descrição já utilizado em outro Serviço!',
            'ser_tipo_servico.required' => 'O Campo Tipo de Serviço é de preenchimento obrigatório!',
            'ser_time_execucao.required' => 'O Campo Tempo de Execução é de preenchimento obrigatório!',
        ];
    }
}
