<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\ContactMessage;
use App\Notifications\ContactReceivedAdmin;
use App\Notifications\ContactReceivedUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Notification;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Marketing/Contact');
    }

    public function store(ContactRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $message = ContactMessage::create($data + ['created_at' => now()]);

        // Reply confirmation to the submitter.
        Notification::route('mail', $data['email'])
            ->notify(new ContactReceivedUser($data['firstname'], $data['inquiry']));

        // Admin copy (dedicated inbox; falls back to the from-address).
        $adminTo = env('MAIL_ADMIN_TO') ?: config('mail.from.address');
        if ($adminTo) {
            Notification::route('mail', $adminTo)
                ->notify(new ContactReceivedAdmin($message));
        }

        return back()->with('success', 'Thanks — we got your message and will respond within 24–48 hours.');
    }
}
