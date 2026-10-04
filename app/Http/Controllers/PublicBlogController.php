<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Repositories\Contracts\BlogPostRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicBlogController extends Controller
{
    public function __construct(
        protected BlogPostRepositoryInterface $blogPostRepository
    ) {}

    public function index(Request $request): View
    {
        $posts = $this->blogPostRepository->getPublishedPaginated(
            9,
            $request->query('category'),
            $request->query('search')
        );

        $categories = Category::withCount('posts')->get();
        $recentPosts = $this->blogPostRepository->getRecentPublished(4);

        return view('pages.blog.index', compact('posts', 'categories', 'recentPosts'));
    }

    public function show(string $slug): View
    {
        $post = $this->blogPostRepository->findBySlug($slug);

        if (! $post || ! $post->is_published) {
            abort(404);
        }

        $categories = Category::withCount('posts')->get();
        $recentPosts = $this->blogPostRepository->getRecentPublished(4);

        return view('pages.blog.show', compact('post', 'categories', 'recentPosts'));
    }
}
