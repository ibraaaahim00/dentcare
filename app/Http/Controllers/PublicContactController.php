<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\StoreContactMessageRequest;
use App\Models\WorkingHour;
use App\Services\ContactService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PublicContactController extends Controller
{
    public function __construct(
        protected ContactService $contactService
    ) {}

    public function index(): View
    {
        $workingHours = WorkingHour::orderBy('day_of_week')->get();

        return view('pages.contact', compact('workingHours'));
    }

    public function store(StoreContactMessageRequest $request): RedirectResponse
    {
        $this->contactService->sendMessage($request->validated());

        return redirect()->route('contact')->with('success', __('contact.success', [
            'default' => 'شكراً لتواصلك معنا، تم استلام رسالتك وسنقوم بالرد في أقرب وقت.',
        ]));
    }
}
