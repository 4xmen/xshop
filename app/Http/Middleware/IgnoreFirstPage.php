<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IgnoreFirstPage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if ($request->has('page') && $request->get('page') == '1'){
            $q = $request->all();
            unset($q['page']);
            return redirect($request->url().'?'.http_build_query($q));
        }
        return $next($request);
    }
}
