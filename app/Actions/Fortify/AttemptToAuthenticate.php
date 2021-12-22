<?php

namespace App\Actions\Fortify;

use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Actions\AttemptToAuthenticate as FortifyAttemptToAuthenticate;
use Laravel\Fortify\Fortify;

class AttemptToAuthenticate extends FortifyAttemptToAuthenticate
{
    use UserValidationRules;

    public function handle($request, $next)
    {
        if (
            !Fortify::$authenticateUsingCallback &&
            Validator::make($request->only(Fortify::username(), 'password'), [
                Fortify::username() => $this->baseRules(),
                'password' => $this->baseRules(),
            ])->fails()
        )
            return $this->throwFailedAuthenticationException($request);
        return parent::handle($request, $next);
    }
}
