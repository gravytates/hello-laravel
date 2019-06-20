<?php

namespace App\Http\Middleware;

use Closure;

class AuthenticateWithOkta
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->isAuthorized($request)) {
            return $next($request);
        } else {
            return response('Unauthorized', 401);
        }
    }

    public function isAuthorized($request)
    {
        $clientId = env('CLIENT_ID');
        $issuerURL = env('ISSUER_URL');
        if (! $request->header('Authorization')) {
            return false;
        }

        $authType = null;
        $authData = null;
    
        @list($authType, $authData) = explode(" ", $request->header('Authorization'), 2);

        if ($authType != 'Bearer') {
            return false;
        }

        try {
            $jwtVerifier = (new \Okta\JwtVerifier\JwtVerifierBuilder())
                            ->setAdaptor(new \Okta\JwtVerifier\Adaptors\SpomkyLabsJose())
                            ->setAudience('api://default')
                            ->setClientId($clientId)
                            ->setIssuer($issuerURL)
                            ->build();

            $jwt = $jwtVerifier->verify($authData);
        } catch (\Exception $e) {

            return false;
        }

        return true;
    }
}
