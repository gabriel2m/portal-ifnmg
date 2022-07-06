<?php

namespace App\Http\Requests;

class SearchMaterialRequest extends MaterialRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome' => [
                'nullable',
                'string',
                'max:255',
            ],
            'catmat' => [
                'nullable',
                'integer',
            ],
            'unidade_id' => [
                'nullable',
                'integer',
                'exists:unidades,id'
            ],
            'descricao' => [
                'nullable',
                'string',
                'max:3500',
            ],
        ];
    }
}
