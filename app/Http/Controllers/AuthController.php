<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $user = $this->authService->authenticate(
            $request->validated('email'),
            $request->validated('password')
        );

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return match ($user->role) {
            UserRole::Admin => redirect()->intended(route('admin.dashboard')),
            UserRole::Doctor => redirect()->intended(route('doctor.dashboard')),
            default => redirect()->intended(route('patient.dashboard')),
        };
    }

    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $user = $this->authService->registerPatient($request->validated());

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('patient.dashboard')->with('success', __('auth.registration_success', [
            'name' => $user->name,
        ]));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', __('auth.logout_success', [
            'name' => 'Good bye',
        ]));
    }
}
