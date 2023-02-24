<?php

namespace App\Http\Requests;

use App\Models\Material;
use App\Models\Setor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveMaterialCompraRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'material_id' => [
                'required',
                Rule::exists(Material::class, 'id'),
            ],
            'valor' => [
                'required',
                'numeric',
                'min:0.01',
                'max:999999'
            ],
            'material_compra_setor' => [
                'required',
                'array',
            ],
            'material_compra_setor.*' => Rule::forEach(function ($value, $attribute) {
                return [
                    'array',
                    Rule::excludeIf(empty($value['quantidade'] ?? null))
                ];
            }),
            'material_compra_setor.*.setor_id' => [
                'required',
                'distinct',
                Rule::exists(Setor::class, 'id'),
            ],
            'material_compra_setor.*.quantidade' => [
                'required',
                'integer',
                'min:1',
                'max:9999999'
            ],
        ];
    }

    public function attributes()
    {
        return [
            'material_compra_setor.*.quantidade' => 'quantidade',
            'material_id' => 'material'
        ];
    }
}
