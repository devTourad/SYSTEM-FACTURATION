<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Changer la langue de l'application
     */
    public function changeLanguage(Request $request, $locale)
    {
        // Vérifier que la langue est supportée
        $supportedLocales = ['fr', 'ar'];

        if (in_array($locale, $supportedLocales)) {
            // Stocker la langue dans la session
            Session::put('locale', $locale);

            // Définir la langue pour cette requête
            App::setLocale($locale);
        }

        // Rediriger vers la page précédente
        return redirect()->back();
    }
    
    /**
     * Obtenir la langue actuelle
     */
    public function getCurrentLanguage()
    {
        return Session::get('locale', config('app.locale'));
    }
    
    /**
     * Obtenir toutes les langues supportées
     */
    public function getSupportedLanguages()
    {
        return [
            'fr' => [
                'name' => 'Français',
                'flag' => '🇫🇷',
                'direction' => 'ltr'
            ],
            'ar' => [
                'name' => 'العربية',
                'flag' => '🇸🇦',
                'direction' => 'rtl'
            ]
        ];
    }
}
