<?php

namespace App\Actions\Fortify;

use App\Enums\NivelUser;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

trait UserValidationRules
{

    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    protected function baseRules(bool $required = true)
    {
        return array_filter([
            $required ? 'required' : false,
            'nullable',
            'string',
            'max:255'
        ]);
    }

    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    protected function passwordRules(bool $required = true)
    {
        return [
            ...$this->baseRules($required),
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

    protected function nivelRules()
    {
        return [
            'required',
            Rule::enum(NivelUser::class),
        ];
    }
}
