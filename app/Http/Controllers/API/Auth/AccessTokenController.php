<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\User;
use Laravel\Passport\Http\Controllers\AccessTokenController as ATC;
use Psr\Http\Message\ServerRequestInterface;

class AccessTokenController extends ATC
{
    /**
     * Check username and password and redirect to dashboard also update user device
     * @param ServerRequestInterface $request
     * @return \Illuminate\Http\Response|never
     */
    public function issueToken(ServerRequestInterface $request) {
        $requestUsername = request()->input('username');
        $user = User::where('email', $requestUsername)->orWhere('mobile', $requestUsername)->first();
        if(!$user)  return abort(422, "The credentials are incorrect");

        return parent::issueToken($request);
    }
}
