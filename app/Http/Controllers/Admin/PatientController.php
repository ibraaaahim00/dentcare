<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PatientController extends Controller
{
    public function __construct(
        protected UserRepositoryInterface $userRepository,
        protected FileUploadService $fileUploadService
    ) {}

    public function index(Request $request): View
    {
        $patients = $this->userRepository->getPatientsPaginated(10, $request->query('search'));

        return view('admin.patients.index', compact('patients'));
    }

    public function show(User $patient): View
    {
        $patient->load(['appointments.doctor.user', 'appointments.service', 'medicalRecords.doctor.user', 'reviews']);

        return view('admin.patients.show', compact('patient'));
    }

    public function edit(User $patient): View
    {
        return view('admin.patients.edit', compact('patient'));
    }

    public function update(Request $request, User $patient): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($patient->id)],
            'phone' => ['required', 'string', 'max:20'],
            'gender' => ['nullable', 'in:male,female'],
            'date_of_birth' => ['nullable', 'date'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'password' => ['nullable', 'min:8'],
        ]);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $this->fileUploadService->replace($patient->avatar, $request->file('avatar'), 'avatars');
        }

        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $patient->update($validated);

        return redirect()->route('admin.patients.index')->with('success', 'Patient updated successfully.');
    }

    public function destroy(User $patient): RedirectResponse
    {
        $patient->delete();

        return redirect()->route('admin.patients.index')->with('success', 'Patient deleted successfully.');
    }
}
