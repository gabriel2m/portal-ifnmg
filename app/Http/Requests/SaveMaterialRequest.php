<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class SaveMaterialRequest extends MaterialRequest
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
                'required',
                'string',
                'max:255',
                Rule::unique('materiais')->ignore($this->material),
            ],
            'catmat' => [
                'required',
                'integer',
                Rule::unique('materiais')->ignore($this->material),
            ],
            'unidade_id' => [
                'required',
                'integer',
                'exists:unidades,id'
            ],
            'descricao' => [
                'required',
                'string',
                'max:3500',
            ],
        ];
    }
}
