<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cms\StoreStatisticRequest;
use App\Http\Requests\Cms\UpdateStatisticRequest;
use App\Models\Statistic;
use App\Services\CmsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StatisticController extends Controller
{
    public function __construct(
        protected CmsService $cmsService
    ) {}

    public function index(): View
    {
        $statistics = $this->cmsService->getAllStatistics();

        return view('admin.cms.statistics.index', compact('statistics'));
    }

    public function store(StoreStatisticRequest $request): RedirectResponse
    {
        $this->cmsService->createStatistic($request->validated());

        return redirect()->route('admin.statistics.index')
            ->with('success', __('Statistic created successfully.'));
    }

    public function update(UpdateStatisticRequest $request, Statistic $statistic): RedirectResponse
    {
        $this->cmsService->updateStatistic($statistic->id, $request->validated());

        return redirect()->route('admin.statistics.index')
            ->with('success', __('Statistic updated successfully.'));
    }

    public function destroy(Statistic $statistic): RedirectResponse
    {
        $this->cmsService->deleteStatistic($statistic->id);

        return redirect()->route('admin.statistics.index')
            ->with('success', __('Statistic deleted successfully.'));
    }
}
