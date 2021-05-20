<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        $url = url()->previous();
        if(str_contains($url, "/login")) {
            $url = request()->url();
        }
        session()->put('url.previa', $url);

        if (! $request->expectsJson()) {

            return route('login');
        }
    }
}
