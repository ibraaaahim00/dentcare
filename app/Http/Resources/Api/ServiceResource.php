<?php

namespace App\Http\Resources\Api;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Service
 */
class ServiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name_ar' => $this->name_ar,
            'name_en' => $this->name_en,
            'name' => $this->name,
            'slug' => $this->slug,
            'description_ar' => $this->description_ar,
            'description_en' => $this->description_en,
            'description' => $this->description,
            'duration' => $this->duration,
            'duration_minutes' => $this->duration,
            'price' => (float) $this->price,
            'image_url' => $this->image_url,
            'is_active' => (bool) $this->is_active,
        ];
    }
}
