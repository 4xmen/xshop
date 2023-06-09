<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;


class Acl
{

    private $excepts = ['ckeditor', 'home'];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $route = \Route::getCurrentRoute();
        // check admin page & user is not super admin
        if (auth()->check() && isset($route->action['as'])) {
            // explode user request to process
            $requestPath = explode('.', $route->action['as']);
            // ignore admin and not admin page
            if ($requestPath[0] == 'admin' && !auth()->user()->hasRole('super-admin')) {
                // check excpet and has 3 routes and has user acceess
                if (!in_array($requestPath[1], $this->excepts) &&
                    isset($requestPath[2]) &&
                    !auth()->user()->hasAccess($route->action['as'])) {
                    return abort(403, __("You dont't have acccess this acction"));
                }
                // check delete or destroy with bulk action
                if ($requestPath[2] == 'bulk' && $request->input('bulk') == 'delete') {
                    $requestPath[2] = 'delete';
                    if (!auth()->user()->hasAccess(implode('.', $requestPath))) {
                        $requestPath[2] = 'destroy';
                        if (!auth()->user()->hasAccess(implode('.', $requestPath))) {
                            return abort(403, __("You dont't have acccess this acction"));
                        }
                    }
                }
            }
        }
        return $next($request);
    }
}
