<?php

namespace App\Http\Requests;

use App\Enums\TipoMaterial;
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
            'catmat' => [
                'required',
                'integer',
                Rule::unique('materiais')->ignore($this->material),
            ],
            'nome' => [
                'required',
                'string',
                'max:255',
                Rule::unique('materiais')->ignore($this->material),
            ],
            'tipo' => [
                'required',
                Rule::enum(TipoMaterial::class),
            ],
            'unidades' => [
                'required',
                'array'
            ],
            'unidades.*.unidade_id' => [
                'required',
                'integer',
                'distinct',
                'exists:unidades,id',
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
            'unidades' => 'unidades de medida',
            'unidades.*.unidade_id' => 'unidade de medida',
        ];
    }
}
