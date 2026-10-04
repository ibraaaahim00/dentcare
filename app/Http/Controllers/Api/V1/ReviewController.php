<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Review\StoreReviewRequest;
use App\Http\Resources\Api\ReviewResource;
use App\Repositories\Contracts\ReviewRepositoryInterface;
use App\Services\ReviewService;
use Illuminate\Http\JsonResponse;

class ReviewController extends BaseApiController
{
    public function __construct(
        protected ReviewRepositoryInterface $reviewRepository,
        protected ReviewService $reviewService
    ) {}

    public function index(): JsonResponse
    {
        $reviews = $this->reviewRepository->getApprovedReviews();

        return $this->successResponse(ReviewResource::collection($reviews));
    }

    public function store(StoreReviewRequest $request): JsonResponse
    {
        $review = $this->reviewService->submitReview(
            $request->validated(),
            $request->user()
        );

        return $this->successResponse(
            new ReviewResource($review->load(['patient', 'doctor'])),
            'Review submitted successfully',
            201
        );
    }
}
