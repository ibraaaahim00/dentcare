<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Review\StoreReviewRequest;
use App\Services\ReviewService;
use Illuminate\Http\RedirectResponse;

class ReviewController extends Controller
{
    public function __construct(
        protected ReviewService $reviewService
    ) {}

    public function store(StoreReviewRequest $request): RedirectResponse
    {
        $this->reviewService->submitReview(
            $request->validated(),
            $request->user()
        );

        return redirect()->back()->with('success', __('reviews.success'));
    }
}
