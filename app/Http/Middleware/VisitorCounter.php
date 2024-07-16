<?php

namespace App\Http\Middleware;

use App\Helpers\TVisitor;
use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VisitorCounter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $visitor = Visitor::where('updated_at','>',date("Y-m-d H:i:s" ,time() - (60*60)))
            ->where('ip', $request->ip())->first();
        if ($visitor === null) {
            $visitor = new Visitor();
            $visitor->ip = $request->ip();
            $visitor->browser = TVisitor::DetectBrowser();
            $visitor->os = TVisitor::DetectOS();
            $visitor->version = TVisitor::BrowserVersion();
            $visitor->referer = TVisitor::getRefererDomain();
            $ref =  TVisitor::GetKeyword();
            if ($ref !== null) {
                $visitor->keywords = $ref['keyword'];
                $visitor->engine = $ref['engine'];
            }
            $visitor->is_mobile = TVisitor::IsMobile();
            $visitor->page = $request->route()->getName();
            $visitor->save();
        }else{
            $visitor->increment('visit');
            $visitor->page = $request->route()->getName();
            $visitor->save();
        }
        return $next($request);
    }
}
