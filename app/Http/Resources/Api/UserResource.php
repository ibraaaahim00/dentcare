<?php

namespace App\Http\Resources\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'role' => $this->role?->value,
            'role_label' => $this->role?->label(),
            'gender' => $this->gender?->value,
            'date_of_birth' => $this->date_of_birth?->format('Y-m-d'),
            'avatar_url' => $this->avatar_url,
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
