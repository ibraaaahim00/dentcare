<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\GalleryItemRepositoryInterface;
use Illuminate\View\View;

class PublicGalleryController extends Controller
{
    public function __construct(
        protected GalleryItemRepositoryInterface $galleryItemRepo
    ) {}

    public function __invoke(): View
    {
        $galleryItems = $this->galleryItemRepo->getActive();

        return view('pages.gallery', compact('galleryItems'));
    }
}
