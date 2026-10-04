<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cms\StoreFeatureRequest;
use App\Http\Requests\Cms\UpdateFeatureRequest;
use App\Models\Feature;
use App\Services\CmsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FeatureController extends Controller
{
    public function __construct(
        protected CmsService $cmsService
    ) {}

    public function index(): View
    {
        $features = $this->cmsService->getAllFeatures();

        return view('admin.cms.features.index', compact('features'));
    }

    public function store(StoreFeatureRequest $request): RedirectResponse
    {
        $this->cmsService->createFeature($request->validated());

        return redirect()->route('admin.features.index')
            ->with('success', __('Feature created successfully.'));
    }

    public function update(UpdateFeatureRequest $request, Feature $feature): RedirectResponse
    {
        $this->cmsService->updateFeature($feature->id, $request->validated());

        return redirect()->route('admin.features.index')
            ->with('success', __('Feature updated successfully.'));
    }

    public function destroy(Feature $feature): RedirectResponse
    {
        $this->cmsService->deleteFeature($feature->id);

        return redirect()->route('admin.features.index')
            ->with('success', __('Feature deleted successfully.'));
    }
}
