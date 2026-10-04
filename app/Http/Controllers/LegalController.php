<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class LegalController extends Controller
{
    public function privacyPolicy(): View
    {
        return view('pages.legal.privacy');
    }

    public function terms(): View
    {
        return view('pages.legal.terms');
    }
}
