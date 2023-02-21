<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Artesaos\SEOTools\Facades\SEOTools;
use Closure;
use Illuminate\Http\Request;

class Seo
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $seoSettings = Setting::whereSection('seo')->pluck('value', 'key');
        $image = asset('images/' . str_replace('_', '.', 'site_image'));

        SEOTools::setTitle($seoSettings->get('site_name', config('app.name')));
        SEOTools::setDescription($seoSettings->get('site_description'));

        \SEOMeta::setKeywords(explode('،', $seoSettings->get('site_keywords')));

        \OpenGraph::addImage($image);

        \Twitter::setImage($image);

        \JsonLd::setImage($image);

        return $next($request);
    }
}
