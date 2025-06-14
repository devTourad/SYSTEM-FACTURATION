<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Langues supportées
        $supportedLocales = ['fr', 'ar'];

        // Obtenir la langue depuis la session ou utiliser la langue par défaut
        $locale = Session::get('locale', config('app.locale'));

        // Vérifier que la langue est supportée
        if (in_array($locale, $supportedLocales)) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
