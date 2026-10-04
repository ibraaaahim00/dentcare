<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cms\StoreGalleryItemRequest;
use App\Http\Requests\Cms\UpdateGalleryItemRequest;
use App\Models\GalleryItem;
use App\Repositories\Contracts\GalleryItemRepositoryInterface;
use App\Services\CmsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function __construct(
        protected CmsService $cmsService,
        protected GalleryItemRepositoryInterface $galleryItemRepo
    ) {}

    public function index(): View
    {
        $items = $this->galleryItemRepo->paginate(12);

        return view('admin.gallery.index', compact('items'));
    }

    public function store(StoreGalleryItemRequest $request): RedirectResponse
    {
        $this->cmsService->createGalleryItem(
            $request->validated(),
            $request->file('image'),
            $request->file('before_image'),
            $request->file('after_image')
        );

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item uploaded successfully.');
    }

    public function update(UpdateGalleryItemRequest $request, GalleryItem $gallery): RedirectResponse
    {
        $this->cmsService->updateGalleryItem(
            $gallery->id,
            $request->validated(),
            $request->file('image'),
            $request->file('before_image'),
            $request->file('after_image')
        );

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item updated successfully.');
    }

    public function destroy(GalleryItem $gallery): RedirectResponse
    {
        $this->cmsService->deleteGalleryItem($gallery->id);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item deleted successfully.');
    }

    public function toggle(GalleryItem $gallery): RedirectResponse
    {
        $this->cmsService->toggleGalleryItem($gallery->id);

        return back()->with('success', 'Gallery item status updated successfully.');
    }
}
