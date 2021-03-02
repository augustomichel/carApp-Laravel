<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateProdutoRequest extends FormRequest
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

            if ($this->input('pro_nome') != $this->input('pro_nome_old')) {
                $validacoes['pro_nome'] = 'required:|unique:produto';
            }

            return $validacoes;
        } else {
            return [
                'pro_nome'   => 'required:|unique:produto',
            ];
        }
    }

    public function messages()
    {
        return [
            'pro_nome.required'    => 'O Campo nome é de preenchimento obrigatório!',
            'pro_nome.unique'     => 'O Campo nome já utilizado em outro Produto!',
        ];
    }
}
