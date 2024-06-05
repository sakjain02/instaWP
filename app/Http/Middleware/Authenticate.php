<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use URL;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (!$request->expectsJson()) {
            if (stripos(URL::current(), 'api') !== false) {
                echo json_encode(['success' => false, 'message' => 'Unauthenticated', 'status' => 400]);
                exit;
            } else {
                return route('login');
            }
        }
        // return $request->expectsJson() ? null : route('login');
    }
}
