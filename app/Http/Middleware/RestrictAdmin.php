<?php

namespace App\Http\Middleware;

use App\Http\Library\ApiHelpers;
use Closure;
use Illuminate\Http\Request;

class RestrictAdmin
{

    use ApiHelpers;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if ($request->user()->role === 'admin') {
            return $next($request);
        }
        return $this->onError(401, 'Invalid action for this role');
    }
}