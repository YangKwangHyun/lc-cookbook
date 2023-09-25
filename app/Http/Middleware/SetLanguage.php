<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->segment(1);

        if(!in_array($locale, config('app.locales'))) {
            // redirect to current page with fallback locale
            return redirect(url(getCurrentUrlWithLocale(config('app.fallback_locale'))));
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
