<?php

namespace App\Http\Resources\Api;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Review
 */
class ReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'rating' => $this->rating,
            'comment' => $this->comment,
            'status' => $this->status?->value,
            'patient_name' => $this->patient?->name,
            'patient_avatar' => $this->patient?->avatar_url,
            'doctor_name' => $this->doctor?->name,
            'created_at' => $this->created_at?->diffForHumans(),
        ];
    }
}
