<?php

namespace Brunocfalcao\Tracer\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class JobRateLimited
{
    public function handle(object $job, Closure $next, $limit = 1, $every = 5): void
    {
        Redis::throttle('key')
             ->block(0)->allow($limit)->every($every)
             ->then(function () use ($job, $next) {
                    $next($job);
             }, function () use ($job) {
                 $job->release(5);
             });
    }
}
