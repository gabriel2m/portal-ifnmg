<?php

namespace App\Http\Requests;

use App\Enums\UserPermission;
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
        $has_admin_permission = auth()->user()->hasPermission(UserPermission::Admin);

        return [
            'material_unidade_id' => [
                Rule::exists(MaterialUnidade::class, 'id')->whereNull('deleted_at'),
            ],
            'quantidades' => [
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
            'valores' => [
                'required',
                'array',
                'max:5'
            ],
            'valores.*' => Rule::forEach(fn ($value) => [
                'array',
                Rule::excludeIf(empty($value['valor']))
            ]),
            'valores.*.valor' => [
                'numeric',
                'min:0.01',
                'max:9999999'
            ],
            'responsavel_valores' => [
                Rule::excludeIf(!$has_admin_permission),
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }

    public function attributes()
    {
        return [
            'material_unidade_id' => 'material',
            'quantidades.*.setor_id' => 'setor',
            'quantidades.*.quantidade' => 'quantidade',
            'valores.*.valor' => 'valor',
            'responsavel_valores' => 'responsável pela cotação'
        ];
    }
}
