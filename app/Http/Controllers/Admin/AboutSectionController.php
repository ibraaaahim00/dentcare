<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cms\UpdateAboutSectionRequest;
use App\Services\CmsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AboutSectionController extends Controller
{
    public function __construct(
        protected CmsService $cmsService
    ) {}

    public function edit(): View
    {
        $about = $this->cmsService->getAboutSection();

        return view('admin.cms.about.edit', compact('about'));
    }

    public function update(UpdateAboutSectionRequest $request): RedirectResponse
    {
        $this->cmsService->saveAboutSection(
            $request->validated(),
            $request->file('image'),
            $request->file('secondary_image')
        );

        return redirect()->route('admin.about-section.edit')
            ->with('success', __('About section updated successfully.'));
    }
}
