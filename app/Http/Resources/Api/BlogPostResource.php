<?php

namespace App\Http\Resources\Api;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin BlogPost
 */
class BlogPostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title_ar' => $this->title_ar,
            'title_en' => $this->title_en,
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt_ar' => $this->excerpt_ar,
            'excerpt_en' => $this->excerpt_en,
            'excerpt' => $this->excerpt,
            'content_ar' => $this->content_ar,
            'content_en' => $this->content_en,
            'content' => $this->content,
            'image_url' => $this->image_url,
            'published_at' => $this->published_at?->format('Y-m-d'),
            'author_name' => $this->author?->name,
            'categories' => $this->categories->map(fn ($cat) => [
                'id' => $cat->id,
                'name' => $cat->name,
                'slug' => $cat->slug,
            ]),
        ];
    }
}
