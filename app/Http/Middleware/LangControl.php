<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\URL;

class LangControl
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $segments = $request->segments();
        if (strlen($segments[0]) == 2 && preg_match('/[A-Za-z]/', $segments[0])) {
            app()->setLocale($segments[0]);

            $request->attributes->set('set_lang', true);
            \Session::put('locate',app()->getLocale());
            \Session::save();
        } else {
            app()->setLocale(config('app.locale'));
        }
//        array_shift($segments);
//        $url = \request()->path();
//        $url = str_replace(app()->getLocale(), '', $url);
//        // Modify the request
//        $newPath = '/' . implode('/', $segments);
//        $newUrl = $request->root() . $newPath . ($request->getQueryString() ? '?'.$request->getQueryString() : '');
//
//        $request->initialize(
//            $request->query->all(),
//            $request->request->all(),
//            $request->attributes->all(),
//            $request->cookies->all(),
//            $request->files->all(),
//            $request->server->all()
//        );
//


        return $next($request);
    }
}
