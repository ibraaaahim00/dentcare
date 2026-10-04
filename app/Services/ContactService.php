<?php

namespace App\Services;

use App\Enums\ContactMessageStatus;
use App\Models\ContactMessage;
use App\Repositories\Contracts\ContactMessageRepositoryInterface;
use Carbon\Carbon;

class ContactService
{
    public function __construct(
        protected ContactMessageRepositoryInterface $contactMessageRepository
    ) {}

    public function sendMessage(array $data): ContactMessage
    {
        $data['status'] = ContactMessageStatus::Unread;

        /** @var ContactMessage */
        return $this->contactMessageRepository->create($data);
    }

    public function markAsRead(ContactMessage $message): bool
    {
        return $message->update([
            'status' => ContactMessageStatus::Read,
            'read_at' => Carbon::now(),
        ]);
    }
}
