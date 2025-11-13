<?php 

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Exception\HttpResponseException;


class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if ($request->expectsJson()) {
            throw new HttpResponseException(response()->json([
                'message' => 'Acceso no actorizado.Deves iniciar sesion.'
            ],401));
        }
        return null;
    }
}
