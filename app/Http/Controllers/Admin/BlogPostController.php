<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogPost\StoreBlogPostRequest;
use App\Http\Requests\BlogPost\UpdateBlogPostRequest;
use App\Models\BlogPost;
use App\Models\Category;
use App\Repositories\Contracts\BlogPostRepositoryInterface;
use App\Services\FileUploadService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlogPostController extends Controller
{
    public function __construct(
        protected BlogPostRepositoryInterface $blogPostRepository,
        protected FileUploadService $fileUploadService
    ) {}

    public function index(Request $request): View
    {
        $posts = $this->blogPostRepository->getAllPaginated(10, $request->query('search'));

        return view('admin.blog.index', compact('posts'));
    }

    public function create(): View
    {
        $categories = Category::all();

        return view('admin.blog.create', compact('categories'));
    }

    public function store(StoreBlogPostRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['author_id'] = $request->user()->id;

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title_en'] ?? $validated['title_ar']);
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $this->fileUploadService->upload($request->file('image'), 'blog');
        }

        if (! empty($validated['is_published']) && empty($validated['published_at'])) {
            $validated['published_at'] = Carbon::now();
        }

        /** @var BlogPost $post */
        $post = $this->blogPostRepository->create($validated);

        if (! empty($validated['categories'])) {
            $post->categories()->sync($validated['categories']);
        }

        return redirect()->route('admin.blog.index')->with('success', 'Blog post created successfully.');
    }

    public function edit(BlogPost $blog): View
    {
        $blog->load('categories');
        $categories = Category::all();

        return view('admin.blog.edit', compact('blog', 'categories'));
    }

    public function update(UpdateBlogPostRequest $request, BlogPost $blog): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = $this->fileUploadService->replace($blog->image, $request->file('image'), 'blog');
        }

        if (! empty($validated['is_published']) && empty($blog->published_at)) {
            $validated['published_at'] = Carbon::now();
        }

        $blog->update($validated);

        if (isset($validated['categories'])) {
            $blog->categories()->sync($validated['categories']);
        }

        return redirect()->route('admin.blog.index')->with('success', 'Blog post updated successfully.');
    }

    public function destroy(BlogPost $blog): RedirectResponse
    {
        if ($blog->image) {
            $this->fileUploadService->delete($blog->image);
        }

        $blog->delete();

        return redirect()->route('admin.blog.index')->with('success', 'Blog post deleted successfully.');
    }
}
