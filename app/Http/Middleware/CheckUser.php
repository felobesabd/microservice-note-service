<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $guard = null): Response
    {
        function exceptionError() {
            throw new HttpResponseException(response()->json([
                'status' => 'error',
                'message' => 'The given data was invalid.',
                'errors' => "Invalid token please login and try again..",
            ], 403));
        }

        $token = $request->headers->get('Authorization');

        if (empty($token)) {
            exceptionError();
        }

        $token = explode(' ', $token);

        // var_dump($token);

        if (!isset($token[1])) {
            exceptionError();
        }

        $token = $token[1];
        try {
            $data = JWT::decode($token, new Key('skrttoken', 'HS256'));

            if (date('Y-m-d H:i:s') > $data->expiredAt) {
                exceptionError();
            }

            $request->headers->add([
                'user_id' => $data->userId,
                'username' => $data->username
            ]);

        } catch (\Exception $exception) {
            var_dump($exception->getMessage());

            exceptionError();
        }

        return $next($request);
    }
}
