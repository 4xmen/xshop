<?php

namespace App\Http\Middleware;

use App\Helpers\TVisitor;
use App\Models\Visitor;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VisitorDetector
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
            $visitor->browser = TVisitor::DetectBrowserI();
            $visitor->os = TVisitor::DetectOSI();
            $visitor->version = TVisitor::BrowserVersion();
            $visitor->keywords = TVisitor::GetKeyword();
            $visitor->is_mobile = TVisitor::IsMobile();
            $visitor->save();
        }else{
            $visitor->increment('visit');
        }
        return $next($request);
    }
}
