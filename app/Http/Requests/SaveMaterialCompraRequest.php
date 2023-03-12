<?php

namespace App\Http\Requests;

use App\Models\MaterialUnidade;
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
            'material_unidade_id' => [
                'required',
                Rule::exists(MaterialUnidade::class, 'id')->whereNull('deleted_at'),
            ],
            'quantidades' => [
                'required',
                'array',
            ],
            'quantidades.*.setor_id' => [
                'required',
                'distinct',
                Rule::exists(Setor::class, 'id')->whereNull('deleted_at'),
            ],
            'quantidades.*.quantidade' => [
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
            'quantidades.*.setor_id' => 'setor',
            'quantidades.*.quantidade' => 'quantidade',
            'material_unidade_id' => 'material'
        ];
    }
}
