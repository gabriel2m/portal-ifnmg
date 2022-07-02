<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
