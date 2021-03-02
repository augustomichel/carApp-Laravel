<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateClienteRequest extends FormRequest
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

            if ($this->input('cli_nome') != $this->input('cli_nome_old')) {
                $validacoes['cli_nome'] = 'required:|unique:cliente';
            }

            if ($this->input('cli_cnp') != $this->input('cli_cnp_old')) {
                $validacoes['cli_cnp'] = 'required:|unique:cliente';
            }

            return $validacoes;
        } else {
            return [
                'cli_nome'   => 'required:|unique:cliente',
                'cli_cnp'    => 'required:|unique:cliente'
            ];
        }
    }

    public function messages()
    {
        return [
            'cli_nome.required'    => 'O Campo nome é de preenchimento obrigatório!',
            'cli_nome.unique'      => 'O Campo nome já utilizado em outro Cliente!',
            'cli_cnp.required'     => 'O Campo cnp já utilizado em outro Cliente!',
        ];
    }
}
