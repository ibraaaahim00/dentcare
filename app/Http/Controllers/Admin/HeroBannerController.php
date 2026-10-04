<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cms\StoreHeroBannerRequest;
use App\Http\Requests\Cms\UpdateHeroBannerRequest;
use App\Models\HeroBanner;
use App\Services\CmsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HeroBannerController extends Controller
{
    public function __construct(
        protected CmsService $cmsService
    ) {}

    public function index(): View
    {
        $banners = $this->cmsService->getAllBanners();

        return view('admin.cms.hero-banners.index', compact('banners'));
    }

    public function create(): View
    {
        return view('admin.cms.hero-banners.create');
    }

    public function store(StoreHeroBannerRequest $request): RedirectResponse
    {
        $this->cmsService->createBanner(
            $request->validated(),
            $request->file('image'),
            $request->file('mobile_image')
        );

        return redirect()->route('admin.hero-banners.index')
            ->with('success', __('Banner created successfully.'));
    }

    public function edit(HeroBanner $heroBanner): View
    {
        return view('admin.cms.hero-banners.edit', ['banner' => $heroBanner]);
    }

    public function update(UpdateHeroBannerRequest $request, HeroBanner $heroBanner): RedirectResponse
    {
        $this->cmsService->updateBanner(
            $heroBanner->id,
            $request->validated(),
            $request->file('image'),
            $request->file('mobile_image')
        );

        return redirect()->route('admin.hero-banners.index')
            ->with('success', __('Banner updated successfully.'));
    }

    public function destroy(HeroBanner $heroBanner): RedirectResponse
    {
        $this->cmsService->deleteBanner($heroBanner->id);

        return redirect()->route('admin.hero-banners.index')
            ->with('success', __('Banner deleted successfully.'));
    }

    public function toggle(HeroBanner $heroBanner): RedirectResponse
    {
        $this->cmsService->toggleBannerStatus($heroBanner->id);

        return redirect()->route('admin.hero-banners.index')
            ->with('success', __('Banner status toggled successfully.'));
    }
}
