<?php

namespace App\Http\Resources\Api;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Doctor
 */
class DoctorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->user?->email,
            'phone' => $this->user?->phone,
            'specialization' => $this->specialization,
            'bio' => $this->bio,
            'qualifications' => $this->qualifications,
            'experience_years' => $this->experience_years,
            'consultation_fee' => (float) $this->consultation_fee,
            'image_url' => $this->image_url,
            'is_active' => (bool) $this->is_active,
            'average_rating' => $this->average_rating,
            'reviews_count' => $this->reviews_count,
            'services' => ServiceResource::collection($this->whenLoaded('services')),
        ];
    }
}
