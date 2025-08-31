<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VerifyBearerToken
{
    /**
     * Checks to see if the request has the require Bearer Tokens
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        Log::info('perry: handle bearer token: ', [
            'env_bearer_token' => env('BEARER_TOKEN'),
            'token' => $token,
            'services.application.bearerToken' => config('services.application.bearerToken')
        ]);
        if ($token !== config('services.application.bearerToken')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}
