<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Contact\StoreContactMessageRequest;
use App\Services\ContactService;
use Illuminate\Http\JsonResponse;

class ContactController extends BaseApiController
{
    public function __construct(
        protected ContactService $contactService
    ) {}

    public function store(StoreContactMessageRequest $request): JsonResponse
    {
        $this->contactService->sendMessage($request->validated());

        return $this->successResponse(
            null,
            'Your message has been sent successfully. We will get back to you shortly.',
            201
        );
    }
}
