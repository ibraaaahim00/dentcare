<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Repositories\Contracts\ContactMessageRepositoryInterface;
use App\Services\ContactService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function __construct(
        protected ContactMessageRepositoryInterface $contactMessageRepository,
        protected ContactService $contactService
    ) {}

    public function index(Request $request): View
    {
        $messages = $this->contactMessageRepository->getPaginated(12, $request->query('status'));

        return view('admin.contact-messages.index', compact('messages'));
    }

    public function show(ContactMessage $contactMessage): View
    {
        $this->contactService->markAsRead($contactMessage);

        return view('admin.contact-messages.show', compact('contactMessage'));
    }

    public function destroy(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->delete();

        return redirect()->route('admin.contact-messages.index')->with('success', 'Message deleted successfully.');
    }
}
