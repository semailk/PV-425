<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $lang = session()->get('locale') ?? 'ru';
        app()->setLocale($lang);

        return $next($request);
    }
}
