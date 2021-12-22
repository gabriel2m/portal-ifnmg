<?php

namespace App\Http\Responses\Fortify;

use Laravel\Fortify\Http\Responses\SuccessfulPasswordResetLinkRequestResponse as FortifySuccessfulPasswordResetLinkRequestResponse;

class SuccessfulPasswordResetLinkRequestResponse extends FortifySuccessfulPasswordResetLinkRequestResponse
{
    public function toResponse($request)
    {
        $response = parent::toResponse($request);
        if (!$request->wantsJson())
            $response->{'setTargetUrl'}(route('login'));
        return $response;
    }
}
