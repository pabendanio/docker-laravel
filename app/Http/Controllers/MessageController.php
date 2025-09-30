<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitMessageRequest;
use App\Models\Message;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MessageController extends Controller
{
    /**
     * Show the message submission form.
     * @return View
     */
    public function showForm(): View
    {
        return view('message_us');
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

        return redirect('/messages');
    }

    /**
     * Display a list of all submitted messages.
     * @return View
     */
    public function listMessages(): View
    {
        $messages = Message::all();

        return view('messages', ['messages' => $messages]);
    }
}
