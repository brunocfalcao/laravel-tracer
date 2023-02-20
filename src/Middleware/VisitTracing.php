<?php

namespace Brunocfalcao\Tracer\Middleware;

use Closure;
use Illuminate\Http\Request;

class VisitTracing
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        app('tracer-visit')->record();

        return $next($request);
    }
}
