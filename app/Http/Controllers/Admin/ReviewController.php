<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ReviewStatus;
use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Repositories\Contracts\ReviewRepositoryInterface;
use App\Services\ReviewService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function __construct(
        protected ReviewRepositoryInterface $reviewRepository,
        protected ReviewService $reviewService
    ) {}

    public function index(Request $request): View
    {
        $reviews = $this->reviewRepository->getAllPaginated(12, $request->query('status'));

        return view('admin.reviews.index', compact('reviews'));
    }

    public function updateStatus(Request $request, Review $review): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'string', 'in:approved,rejected,pending'],
        ]);

        $this->reviewService->updateStatus($review, ReviewStatus::from($request->status));

        return redirect()->route('admin.reviews.index')->with('success', 'Review status updated successfully.');
    }

    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('success', 'Review deleted successfully.');
    }
}
