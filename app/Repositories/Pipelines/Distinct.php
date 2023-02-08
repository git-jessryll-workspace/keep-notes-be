<?php

namespace App\Repositories\Pipelines;

use Closure;

class Distinct
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next): mixed
    {
        if (!request()->has('need_distinct')) {
            return $next($request);
        }
        $builder = $next($request);
        return $builder->distinct();
    }
}
