<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\LoginViewResponse;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController as FortifyAuthenticatedSessionController;

class AuthenticatedSessionController extends FortifyAuthenticatedSessionController
{
    public function create(Request $request): LoginViewResponse
    {
        $previous = url()->previous();

        if ($previous && $previous != $request->fullUrl())
            redirect()->setIntendedUrl($previous);

        return parent::create($request);
    }
}
