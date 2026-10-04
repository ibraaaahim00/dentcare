<?php

namespace App\Services;

use App\Models\Service;
use App\Repositories\Contracts\ServiceRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ServiceManagementService
{
    public function __construct(
        protected ServiceRepositoryInterface $serviceRepository,
        protected FileUploadService $fileUploadService
    ) {}

    public function createService(array $data, ?UploadedFile $image = null): Service
    {
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name_en'] ?? $data['name_ar']);
        }

        // Ensure unique slug
        $originalSlug = $data['slug'];
        $count = 1;
        while ($this->serviceRepository->findBySlug($data['slug'])) {
            $data['slug'] = "{$originalSlug}-{$count}";
            $count++;
        }

        if ($image) {
            $data['image'] = $this->fileUploadService->upload($image, 'services');
        }

        /** @var Service */
        return $this->serviceRepository->create($data);
    }

    public function updateService(Service $service, array $data, ?UploadedFile $image = null): Service
    {
        if (! empty($data['slug']) && $data['slug'] !== $service->slug) {
            $data['slug'] = Str::slug($data['slug']);
            $originalSlug = $data['slug'];
            $count = 1;
            while (($existing = $this->serviceRepository->findBySlug($data['slug'])) && $existing->id !== $service->id) {
                $data['slug'] = "{$originalSlug}-{$count}";
                $count++;
            }
        }

        if ($image) {
            $data['image'] = $this->fileUploadService->replace($service->image, $image, 'services');
        }

        $service->update($data);

        return $service->refresh();
    }

    public function deleteService(Service $service): bool
    {
        if ($service->image) {
            $this->fileUploadService->delete($service->image);
        }

        return (bool) $service->delete();
    }
}
