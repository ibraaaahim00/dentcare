<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function __construct(
        protected FileUploadService $fileUploadService
    ) {}

    public function index(): View
    {
        $items = GalleryItem::orderBy('sort_order')->paginate(12);

        return view('admin.gallery.index', compact('items'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title_ar' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['image'] = $this->fileUploadService->upload($request->file('image'), 'gallery');
        $validated['is_active'] = $request->boolean('is_active', true);

        GalleryItem::create($validated);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item uploaded successfully.');
    }

    public function destroy(GalleryItem $gallery): RedirectResponse
    {
        $this->fileUploadService->delete($gallery->image);
        $gallery->delete();

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item deleted successfully.');
    }
}
