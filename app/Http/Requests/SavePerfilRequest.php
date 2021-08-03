<?php

namespace App\Http\Requests;

use App\Models\Categoria;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SavePerfilRequest extends FormRequest
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
                Rule::unique('perfis')->ignore($this->perfil)
            ],
            'descricao' => [
                'required',
                'string',
                'max:1000',
            ],
            'categorias' => [
                'required',
                'array',
            ],
            'categorias.*' => [
                'integer',
                Rule::in(Categoria::pluck('id'))
            ],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'descricao' => 'descrição',
            'categorias.*' => 'categoria',
        ];
    }
}
