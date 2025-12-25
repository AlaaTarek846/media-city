<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function changeLanguage($locale)
    {
        if (in_array($locale, ['en', 'ar'])) {
            Session::put('lang', $locale);
            App::setLocale($locale);
        }

        return redirect()->back();
    }
}
