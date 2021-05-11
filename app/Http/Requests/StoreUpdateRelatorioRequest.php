<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateRelatorioRequest extends FormRequest
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
            
            $validacoes['datede'] = 'required';
            $validacoes['dateate'] = 'required';

            return $validacoes;
        } else {
            return [
                'datede'    => 'required',
                'dateate'    => 'required',
            ];
        }
    }

    public function messages()
    {
        return [
            'datede.required' => 'O Campo Inicio preenchimento obrigatório!',
            'dateate.required' => 'O Campo Fim preenchimento obrigatório!',
        ];
    }
}
