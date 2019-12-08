<?php

namespace App\Http\Middleware;

use App\Models\Ip;
use Closure;
use DB;

class CheckIp
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
		$check = DB::select("select `id` from `ips` where (INET_ATON(?) BETWEEN INET_ATON(`from`) AND INET_ATON(`to`))", [$request->ip()]);
		if (!$check) {
            return response('Unauthorized.', 401);
        }

		return $next($request);
    }
}
