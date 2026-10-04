<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;
use Illuminate\View\View;

class PublicGalleryController extends Controller
{
    public function __invoke(): View
    {
        $galleryItems = GalleryItem::active()->get();

        return view('pages.gallery', compact('galleryItems'));
    }
}
