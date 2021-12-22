<?php

namespace App\Http\Responses\Fortify;

use Laravel\Fortify\Http\Responses\PasswordUpdateResponse as FortifyPasswordUpdateResponse;

class PasswordUpdateResponse extends FortifyPasswordUpdateResponse
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $response = parent::toResponse($request);
        if (!$request->wantsJson())
            $response->{'setTargetUrl'}(route('user-profile-information.update'));
        return $response;
    }
}
