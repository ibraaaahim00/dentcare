<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Api\ServiceResource;
use App\Models\Service;
use App\Repositories\Contracts\ServiceRepositoryInterface;
use Illuminate\Http\JsonResponse;

class ServiceController extends BaseApiController
{
    public function __construct(
        protected ServiceRepositoryInterface $serviceRepository
    ) {}

    public function index(): JsonResponse
    {
        $services = $this->serviceRepository->getActiveServices();

        return $this->successResponse(ServiceResource::collection($services));
    }

    public function show(Service $service): JsonResponse
    {
        return $this->successResponse(new ServiceResource($service->load('doctors.user')));
    }
}
