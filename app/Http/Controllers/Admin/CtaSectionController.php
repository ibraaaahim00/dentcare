<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cms\UpdateCtaSectionRequest;
use App\Services\CmsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CtaSectionController extends Controller
{
    public function __construct(
        protected CmsService $cmsService
    ) {}

    public function edit(): View
    {
        $cta = $this->cmsService->getCtaSection();

        return view('admin.cms.cta.edit', compact('cta'));
    }

    public function update(UpdateCtaSectionRequest $request): RedirectResponse
    {
        $this->cmsService->saveCtaSection(
            $request->validated(),
            $request->file('background_image')
        );

        return redirect()->route('admin.cta-section.edit')
            ->with('success', __('Call-to-action section updated successfully.'));
    }
}
