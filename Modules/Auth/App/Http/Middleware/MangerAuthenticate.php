<?php

namespace Modules\Auth\App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;


class MangerAuthenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('manger.login');
    }

    protected function authenticate($request, array $guards)
    {
   
            if ($this->auth->guard('manger')->check()) {
                return $this->auth->shouldUse('manger');
       
        }

        $this->unauthenticated($request, ['manger']);
    }
}
