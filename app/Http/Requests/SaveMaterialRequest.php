<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SaveMaterialRequest extends FormRequest
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

    /**
     * Get custom attributes labels for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'descricao' => 'descrição',
            'unidade_id' => 'unidade'
        ];
    }
}
