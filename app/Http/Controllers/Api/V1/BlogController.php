<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Api\BlogPostResource;
use App\Models\BlogPost;
use App\Repositories\Contracts\BlogPostRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogController extends BaseApiController
{
    public function __construct(
        protected BlogPostRepositoryInterface $blogPostRepository
    ) {}

    public function index(Request $request): JsonResponse
    {
        $posts = $this->blogPostRepository->getPublishedPaginated(
            9,
            $request->category,
            $request->search
        );

        return $this->successResponse(
            BlogPostResource::collection($posts),
            null,
            200,
            [
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'total' => $posts->total(),
            ]
        );
    }

    public function show(BlogPost $post): JsonResponse
    {
        if (! $post->is_published) {
            return $this->errorResponse('Article not found', 404);
        }

        return $this->successResponse(new BlogPostResource($post->load(['author', 'categories'])));
    }
}
