<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * @inheritDoc
     */
    protected function unauthenticated($request, array $guards)
    {
        $redirectTo = null;
        if (!$request->expectsJson()) {
            $guard = collect($guards)->first();

            if ($guard !== 'admin') {
                abort(401);
            }

            $redirectTo = route('admin.login');
        }

        throw new AuthenticationException(
            __('exception.unauthenticated'), $guards, $redirectTo
        );
    }
}
