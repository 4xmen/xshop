<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Acl
{

    private $excepts = ['ckeditor', 'home'];
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $route = \Route::getCurrentRoute();
        // check admin page & user is not super admin
        if (auth()->check() && isset($route->action['as'])) {
            // explode user request to process
            $requestPath = explode('.', $route->action['as']);
            // ignore admin and not admin page
            if ($requestPath[0] == 'admin' && !auth()->user()->hasRole('developer') && !auth()->user()->hasRole('admin')) {
                // check excpet and has 3 routes and has user acceess
                if (!in_array($requestPath[1], $this->excepts) &&
                    isset($requestPath[2]) &&
                    !auth()->user()->hasAccess($route->action['as'])) {
                    return abort(403, __("You don't have access this action"));
                }
                // check delete or destroy with bulk action
                if (isset($requestPath[2]) && $requestPath[2] == 'bulk' && $request->input('bulk') == 'delete') {
                    $requestPath[2] = 'delete';
                    if (!auth()->user()->hasAccess(implode('.', $requestPath))) {
                        $requestPath[2] = 'destroy';
                        if (!auth()->user()->hasAccess(implode('.', $requestPath))) {
                            return abort(403, __("You don't have access this action"));
                        }
                    }
                }
                if (auth()->user()->accesses()->count() == 0){
                    return   redirect()->route('admin.logout')->with(['message' => "You don't have any access to login"]);
                }
            }
        }
        return $next($request);
    }
}
