<?php

namespace App\Http\Requests;

use App\Enums\CategoriaPerfil;
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
                Rule::unique('perfis')->ignore($this->perfil),
            ],
            'imagem' => [
                'exclude_if:imagem,null',
                'image',
                'max:2048',
            ],
            'categoria' => [
                'required',
                Rule::enum(CategoriaPerfil::class)
            ],
            'descricao' => [
                'required',
                'string',
                'max:1000',
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
        return ['descricao' => 'descrição'];
    }
}
