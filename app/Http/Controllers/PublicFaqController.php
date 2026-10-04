<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\FaqRepositoryInterface;
use Illuminate\View\View;

class PublicFaqController extends Controller
{
    public function __construct(
        protected FaqRepositoryInterface $faqRepository
    ) {}

    public function __invoke(): View
    {
        $faqs = $this->faqRepository->getActive();

        return view('pages.faq', compact('faqs'));
    }
}
