<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Api\FaqResource;
use App\Repositories\Contracts\FaqRepositoryInterface;
use Illuminate\Http\JsonResponse;

class FaqController extends BaseApiController
{
    public function __construct(
        protected FaqRepositoryInterface $faqRepository
    ) {}

    public function index(): JsonResponse
    {
        $faqs = $this->faqRepository->getActive();

        return $this->successResponse(FaqResource::collection($faqs));
    }
}
