<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateUsuarioRequest extends FormRequest
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

            if (!empty(trim($this->input('usu_senha')))) {
                $validacoes['usu_senha'] = 'required';
            }

            $validacoes['usu_nivel'] = 'required';

            return $validacoes;
        } else {
            return [
                'usu_nome'    => 'required',
                'usu_email'   => 'required:|unique:usuario',
                'usu_senha'   => 'required',
                'usu_nivel'   => 'required'
            ];
        }
    }

    public function messages()
    {
        return [
            'usu_nome.required'    => 'O Campo nome é de preenchimento obrigatório!',
            'usu_email.unique'     => 'O Campo Email já utilizado em outro Usuário!',
            'usu_cliente.required' => 'O Campo Cliente é de preenchimento obrigatório!',
            'usu_email.required'   => 'O Campo Email é de preenchimento obrigatório!',
            'usu_senha.required'   => 'O Campo Senha é de preenchimento obrigatório!',
            'usu_nivel.required'   => 'O Campo Nivel de Acesso deve ser selecionado!'
        ];
    }
}
