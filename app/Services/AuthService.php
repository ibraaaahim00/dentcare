<?php

namespace App\Services;

use App\Enums\UserRole;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    /**
     * Register a new patient account.
     */
    public function registerPatient(array $data): User
    {
        $data['role'] = UserRole::Patient;

        /** @var User */
        return $this->userRepository->create($data);
    }

    /**
     * Authenticate user credentials and return User model.
     *
     * @throws ValidationException
     */
    public function authenticate(string $email, string $password): User
    {
        $user = $this->userRepository->findByEmail($email);

        if (! $user || ! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')],
            ]);
        }

        return $user;
    }

    /**
     * Generate API Sanctum token for authenticated user.
     */
    public function createApiToken(User $user, string $deviceName = 'api'): string
    {
        return $user->createToken($deviceName)->plainTextToken;
    }
}
