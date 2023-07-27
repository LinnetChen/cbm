<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;

class setReturnUrl
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
        $url = base64_encode("https://".request()->server('HTTP_HOST').request()->server('REQUEST_URI'));
        SetCookie("return_url",$url,0,"/",'.digeam.com');
        return $next($request)->cookie('return_url', $url , 120);
    }
}
