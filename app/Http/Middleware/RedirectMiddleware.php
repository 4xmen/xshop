<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class RedirectMiddleware
{
    /**
     * handle incoming request and apply active redirects
     * uses cached db query (5 min ttl) for performance
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {

        $source = '/' . ltrim($request->path(), '/'); // current path without query string

        // cache redirect per source for 5 minutes
        $destination = Cache::remember("redirect:{$source}", 300, function () use ($source) {
            return DB::table('redirects')
                ->where('source', $source)
                ->where('status', true)
                ->where(function ($query) {
                    $query->whereNull('expire')
                        ->orWhere('expire', '>', now());
                })
                ->value('destination'); // only get destination string
        });

        // if valid redirect found, perform 301
        if ($destination) {
            return redirect($destination, 301);
        }

        // no redirect, continue to next middleware/route
        return $next($request);
    }
}
