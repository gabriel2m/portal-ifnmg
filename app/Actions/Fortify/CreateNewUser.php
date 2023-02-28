<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use UserValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        extract(
            Validator::make($input, [
                'name' => $this->nameRules(),
                'email' => $this->emailRules(),
                'password' => $this->passwordRules(),
                'nivel' => $this->nivelRules()
            ])->validate()
        );

        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'nivel' => $nivel
        ]);
    }
}
