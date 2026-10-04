<?php

namespace App\Http\Resources\Api;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Faq
 */
class FaqResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'question_ar' => $this->question_ar,
            'question_en' => $this->question_en,
            'question' => $this->question,
            'answer_ar' => $this->answer_ar,
            'answer_en' => $this->answer_en,
            'answer' => $this->answer,
        ];
    }
}
