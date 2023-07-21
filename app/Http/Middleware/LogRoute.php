<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class LogRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $Request, Closure $next)
    {
        $response = $next($Request);
        if(app()->environment('local')){
            $log=[
                'URI'=>$Request->getUri(),
                'METHOD'=>$Request->getMethod(),
                'REQUEST_BODY'=>$Request->all(),
                'RESOPNSE'=>$response->getContent()
            ];
            Log::info(json_encode($log));
        }
        return $response;
    }
}
