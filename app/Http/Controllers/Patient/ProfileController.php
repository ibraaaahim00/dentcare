<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct(
        protected FileUploadService $fileUploadService
    ) {}

    public function edit(Request $request): View
    {
        $user = $request->user();

        return view('patient.profile', compact('user'));
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $this->fileUploadService->replace(
                $user->avatar,
                $request->file('avatar'),
                'avatars'
            );
        }

        if (! empty($validated['new_password'])) {
            $validated['password'] = Hash::make($validated['new_password']);
        }

        unset($validated['current_password'], $validated['new_password'], $validated['new_password_confirmation']);

        $user->update($validated);

        return redirect()->route('patient.profile.edit')->with('success', 'Profile updated successfully.');
    }
}
