<?php

namespace App\Http\Requests;

use App\Models\Unidade;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveUnidadeRequest extends FormRequest
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
                Rule::unique(Unidade::class)->ignore($this->unidade),
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
        return ['nome' => 'nome unidade'];
    }
}
