<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class BlockAIBots
{
    /**
     * List of known AI bot user agents (updated as of late 2025)
     * Contains partial strings for matching (case-insensitive)
     */
    private array $aiBotPatterns = [
        'gptbot',               // OpenAI GPTBot
        'chatgpt-user',         // ChatGPT user agent
        'oai-searchbot',        // OpenAI search
        'claudebot',            // Anthropic Claude
        'claudewbot',           // Variant
        'anthropic-ai',         // Anthropic
        'grok',                 // xAI Grok (if they have a crawler)
        'bytespider',           // ByteDance (TikTok)
        'ccbot',                // Common Crawl (used by many AI)
        'amazonbot',            // Amazon
        'applebot',             // Apple (AI features)
        'perplexitybot',        // Perplexity AI
        'perplexity-ai',
        'diffbot',              // Often used for AI
        'facebookexternalhit',  // Meta AI
        'meta-externalagent',
        'omgilibot',            // OMGI (sometimes AI)
        'omg-imagebot',
        'imagesiftbot',
        'google-extended',      // Google AI extended
        'googleother',          // Google AI variants
        'cohere-ai',            // Cohere
        'ai-crawler',           // Generic AI crawlers
        'scraper',              // Common in scrapers
        'crawler for ai',
        'trainingbot',
        'llm',                  // Large Language Model hints
        'genai',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        // config check
        if (!config('app.privacy.block_ai_bots')) {
            return $next($request);
        }

        $userAgent = strtolower($request->header('User-Agent', ''));

        // check ai user agents
        foreach ($this->aiBotPatterns as $pattern) {
            if (str_contains($userAgent, $pattern)) {
                Log::warning('AI Bot Blocked', [
                    'ip' => $request->ip(),
                    'user_agent' => $request->header('User-Agent'),
                    'url' => $request->fullUrl(),
                    'pattern' => $pattern,
                ]);

                return response('Access denied: AI crawlers are not allowed.', 403);
            }
        }

        return $next($request);
    }
}
