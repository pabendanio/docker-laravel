<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class MessageController extends Controller
{
    public function showForm()
    {
        return view('message_us');
    }

    public function submitForm(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|min:10|max:1000',
        ]);

        Message::create($validated);

        return redirect('/messages');
    }

    public function listMessages()
    {
        $messages = Message::all();

        return view('messages', ['messages' => $messages]);
    }
}
