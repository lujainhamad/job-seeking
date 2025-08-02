<?php

namespace App\Http\Middleware;

// use App;
use App\Exceptions\CustomExceptionWithMessage;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App as FacadesApp;
use Symfony\Component\HttpFoundation\Response;

class ApiLocalization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $availablablesLocales = ['ar', 'en'];
        $requestLocale = $request->header('language', 'en');

        if (!in_array($requestLocale, $availablablesLocales)) {
            throw new CustomExceptionWithMessage('Not supported language specified in request header');
        }

        app()->setLocale($requestLocale);

        return $next($request);
    }
}
