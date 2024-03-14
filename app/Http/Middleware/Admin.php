<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth()->user()->account_type == 'Admin' || Auth()->user()->account_type == 'Super Admin') {
            return $next($request);
        }
        abort(401);
    }
}