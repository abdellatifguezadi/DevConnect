<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];

    /**
     * Determine if the request has a valid CSRF token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function tokensMatch($request)
    {
        $token = $request->header('X-CSRF-TOKEN');

        if (!$token && $request->header('X-Requested-With') === 'XMLHttpRequest') {
            $token = $request->header('X-XSRF-TOKEN');
        }

        if (!$token) {
            $token = $request->input('_token');
        }

        if (!$token && $request->isMethod('DELETE')) {
            $token = $request->header('X-CSRF-TOKEN');
        }

        return is_string($token) && hash_equals($request->session()->token(), $token);
    }
} 