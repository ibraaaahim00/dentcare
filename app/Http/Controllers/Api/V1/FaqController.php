<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Api\FaqResource;
use App\Models\Faq;
use Illuminate\Http\JsonResponse;

class FaqController extends BaseApiController
{
    public function index(): JsonResponse
    {
        $faqs = Faq::active()->get();

        return $this->successResponse(FaqResource::collection($faqs));
    }
}
