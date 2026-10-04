<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Services\DoctorService;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(
        protected DoctorService $doctorService,
        protected FileUploadService $fileUploadService
    ) {}

    public function edit(Request $request): View
    {
        $doctor = $request->user()->doctor->load('services');
        $allServices = Service::active()->get();

        return view('doctor.profile', compact('doctor', 'allServices'));
    }

    public function update(Request $request): RedirectResponse
    {
        $doctor = $request->user()->doctor;
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['required', 'string', 'max:20'],
            'specialization' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'qualifications' => ['nullable', 'string'],
            'experience_years' => ['required', 'integer', 'min:0'],
            'consultation_fee' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'services' => ['nullable', 'array'],
            'services.*' => ['integer', 'exists:services,id'],
            'current_password' => ['nullable', 'required_with:new_password', 'current_password'],
            'new_password' => ['nullable', 'min:8', 'confirmed'],
        ]);

        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ];

        if (! empty($validated['new_password'])) {
            $userData['password'] = Hash::make($validated['new_password']);
        }

        $doctorData = [
            'specialization' => $validated['specialization'],
            'bio' => $validated['bio'] ?? null,
            'qualifications' => $validated['qualifications'] ?? null,
            'experience_years' => $validated['experience_years'],
            'consultation_fee' => $validated['consultation_fee'],
        ];

        $this->doctorService->updateDoctor(
            $doctor,
            $userData,
            $doctorData,
            $request->file('image'),
            $validated['services'] ?? []
        );

        return redirect()->route('doctor.profile.edit')->with('success', 'Profile updated successfully.');
    }
}
