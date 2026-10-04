<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\StoreServiceRequest;
use App\Http\Requests\Service\UpdateServiceRequest;
use App\Models\Service;
use App\Repositories\Contracts\ServiceRepositoryInterface;
use App\Services\ServiceManagementService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function __construct(
        protected ServiceRepositoryInterface $serviceRepository,
        protected ServiceManagementService $serviceManagementService
    ) {}

    public function index(Request $request): View
    {
        $services = $this->serviceRepository->getPaginated(10, $request->query('search'));

        return view('admin.services.index', compact('services'));
    }

    public function create(): View
    {
        return view('admin.services.create');
    }

    public function store(StoreServiceRequest $request): RedirectResponse
    {
        $this->serviceManagementService->createService(
            $request->validated(),
            $request->file('image')
        );

        return redirect()->route('admin.services.index')->with('success', 'Dental service created successfully.');
    }

    public function edit(Service $service): View
    {
        return view('admin.services.edit', compact('service'));
    }

    public function update(UpdateServiceRequest $request, Service $service): RedirectResponse
    {
        $this->serviceManagementService->updateService(
            $service,
            $request->validated(),
            $request->file('image')
        );

        return redirect()->route('admin.services.index')->with('success', 'Dental service updated successfully.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $this->serviceManagementService->deleteService($service);

        return redirect()->route('admin.services.index')->with('success', 'Dental service deleted successfully.');
    }
}
