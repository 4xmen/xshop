<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\False_;

class UnderConstruction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (\App\Helpers\getSetting('under') == 'yes' & (!auth()->check()) ){
            return response()->view('website.under');
        }else{
            return $next($request);
        }
    }
}
