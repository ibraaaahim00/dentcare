<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Faq\StoreFaqRequest;
use App\Http\Requests\Faq\UpdateFaqRequest;
use App\Models\Faq;
use App\Repositories\Contracts\FaqRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FaqController extends Controller
{
    public function __construct(
        protected FaqRepositoryInterface $faqRepository
    ) {}

    public function index(): View
    {
        $faqs = $this->faqRepository->paginate(12);

        return view('admin.faqs.index', compact('faqs'));
    }

    public function store(StoreFaqRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', true);

        $this->faqRepository->create($data);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ added successfully.');
    }

    public function update(UpdateFaqRequest $request, Faq $faq): RedirectResponse
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active', true);

        $this->faqRepository->update($faq->id, $data);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated successfully.');
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $this->faqRepository->delete($faq->id);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ deleted successfully.');
    }

    public function toggle(Faq $faq): RedirectResponse
    {
        $this->faqRepository->toggleActive($faq->id);

        return back()->with('success', 'FAQ status updated successfully.');
    }
}
