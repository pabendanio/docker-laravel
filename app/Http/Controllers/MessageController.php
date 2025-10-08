<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitMessageRequest;
use App\Models\Message;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\View as FacesView;

class MessageController extends Controller
{
    /**
     * Show the message submission form.
     * @return View
     */
    public function showForm(): View
    {
        return FacesView::make('index');
    }

    /**
     * Handle the form submission.
     * @param SubmitMessageRequest $request
     * @return RedirectResponse
     */
    public function submitForm(SubmitMessageRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        Message::create($validated);

        return redirect()->route('messages')
            ->with('success', 'Your message has been sent successfully!');
    }

    /**
     * Display a list of all submitted messages.
     * @return View
     */
    public function listMessages(): View
    {
        $messages = Message::query()
            ->orderBy('created_at', 'desc')
            ->get();


        return FacesView::make('messageList', ['messages' => $messages]);
    }
}
