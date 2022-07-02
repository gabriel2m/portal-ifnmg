<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class SaveItemRequest extends ItemRequest
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
                Rule::unique('itens')->ignore($this->item),
            ],
            'catmat' => [
                'required',
                'integer',
                Rule::unique('itens')->ignore($this->item),
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
