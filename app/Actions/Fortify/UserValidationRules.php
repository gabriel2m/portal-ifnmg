<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

trait UserValidationRules
{

    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    protected function baseRules()
    {
        return [
            'required',
            'string',
            'max:255'
        ];
    }

    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    protected function passwordRules()
    {
        return [
            ...$this->baseRules(),
            Password::min(8),
            'confirmed'
        ];
    }

    protected function nameRules($ignore = null)
    {
        return [
            ...$this->baseRules(),
            Rule::unique('users')->ignore($ignore)
        ];
    }

    protected function emailRules($ignore = null)
    {
        return [
            ...$this->baseRules(),
            'email',
            Rule::unique('users')->ignore($ignore),
        ];
    }
}
