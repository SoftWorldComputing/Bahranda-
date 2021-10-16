<?php

namespace App\Http\Middleware;

use App\Exceptions\UserNotAuthenticatedException;
use App\Response\BahrandaResponse;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    use BahrandaResponse;
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
       throw new UserNotAuthenticatedException("User not authenticated");
        // return $this->error("User not authenticated",403);
    }

}
