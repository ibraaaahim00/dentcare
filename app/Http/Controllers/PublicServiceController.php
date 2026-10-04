<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\ServiceRepositoryInterface;
use Illuminate\View\View;

class PublicServiceController extends Controller
{
    public function __construct(
        protected ServiceRepositoryInterface $serviceRepository
    ) {}

    public function index(): View
    {
        $services = $this->serviceRepository->getActiveServices();

        return view('pages.services.index', compact('services'));
    }

    public function show(string $slug): View
    {
        $service = $this->serviceRepository->findBySlug($slug);

        if (! $service || ! $service->is_active) {
            abort(404);
        }

        $service->load('doctors.user');

        return view('pages.services.show', compact('service'));
    }
}
