<?php

namespace App\Http\Controllers;

class LanguageSwitchController extends Controller
{
    /**
     * check setLocale middleware
     */
    public function __invoke($locale)
    {
        if (array_key_exists($locale, config('app.supported_languages'))) {
            session()->put('locale', $locale);
        }

        return redirect()->back();
    }
}
