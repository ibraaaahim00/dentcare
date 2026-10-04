<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cms\StoreHowItWorkRequest;
use App\Http\Requests\Cms\UpdateHowItWorkRequest;
use App\Models\HowItWork;
use App\Services\CmsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HowItWorkController extends Controller
{
    public function __construct(
        protected CmsService $cmsService
    ) {}

    public function index(): View
    {
        $steps = $this->cmsService->getAllHowItWorks();

        return view('admin.cms.how-it-works.index', compact('steps'));
    }

    public function store(StoreHowItWorkRequest $request): RedirectResponse
    {
        $this->cmsService->createHowItWork($request->validated());

        return redirect()->route('admin.how-it-works.index')
            ->with('success', __('Step created successfully.'));
    }

    public function update(UpdateHowItWorkRequest $request, HowItWork $howItWork): RedirectResponse
    {
        $this->cmsService->updateHowItWork($howItWork->id, $request->validated());

        return redirect()->route('admin.how-it-works.index')
            ->with('success', __('Step updated successfully.'));
    }

    public function destroy(HowItWork $howItWork): RedirectResponse
    {
        $this->cmsService->deleteHowItWork($howItWork->id);

        return redirect()->route('admin.how-it-works.index')
            ->with('success', __('Step deleted successfully.'));
    }
}
