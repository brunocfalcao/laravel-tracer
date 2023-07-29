<?php

namespace Brunocfalcao\LaravelTracer\Middleware;

use Closure;
use Illuminate\Http\Request;

class VisitTracing
{
    public function handle(Request $request, Closure $next)
    {
        if (!app()->runningInConsole()) {
            app('tracer-visit')->record();
        }

        return $next($request);
    }
}
