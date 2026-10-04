<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\View\View;

class PublicFaqController extends Controller
{
    public function __invoke(): View
    {
        $faqs = Faq::active()->get();

        return view('pages.faq', compact('faqs'));
    }
}
