<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\CustomerJob;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $conversations = collect();

        if ($user->isCustomer()) {
            $conversations = Conversation::where('customer_id', $user->id)
                ->with(['professional', 'job', 'lastMessage'])
                ->get();
        } elseif ($user->isProfessional()) {
            $conversations = Conversation::where('professional_id', $user->id)
                ->with(['customer', 'job', 'lastMessage'])
                ->get();
        }

        return view('messages.index', compact('conversations'));
    }

    public function show($id)
    {
        $user = Auth::user();
        $conversation = Conversation::with(['job', 'customer', 'professional', 'messages.sender'])->findOrFail($id);

        // Check if user is part of this conversation
        if ($user->isCustomer() && $conversation->customer_id !== $user->id) {
            abort(403);
        }
        if ($user->isProfessional() && $conversation->professional_id !== $user->id) {
            abort(403);
        }

        // Mark messages as read
        $unreadMessages = $conversation->messages()
            ->where('is_read', false)
            ->where('sender_id', '!=', $user->id)
            ->get();
        foreach ($unreadMessages as $msg) {
            $msg->update(['is_read' => true]);
        }

        return view('messages.show', compact('conversation'));
    }

    public function store(Request $request, $conversationId)
    {
        $user = Auth::user();
        $conversation = Conversation::findOrFail($conversationId);

        // Check if user is part of this conversation
        if ($user->isCustomer() && $conversation->customer_id !== $user->id) {
            abort(403);
        }
        if ($user->isProfessional() && $conversation->professional_id !== $user->id) {
            abort(403);
        }

        $request->validate([
            'message_text' => 'required|string',
        ]);

        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'sender_role' => $user->isCustomer() ? 'customer' : 'professional',
            'message_text' => $request->message_text,
            'is_read' => false,
        ]);

        return back();
    }

    public function getOrCreate($jobId)
    {
        $user = Auth::user();
        $job = CustomerJob::findOrFail($jobId);

        $conversation = Conversation::firstOrCreate(
            ['job_id' => $job->id],
            [
                'customer_id' => $job->customer_id,
                'professional_id' => $job->assigned_pro_id,
            ]
        );

        return redirect()->route('messages.show', $conversation->id);
    }

    public function getUnreadCount()
    {
        $user = Auth::user();
        return response()->json(['count' => $user->unreadMessagesCount()]);
    }

    public function getMessages($conversationId)
    {
        $user = Auth::user();
        $conversation = Conversation::findOrFail($conversationId);

        if ($user->isCustomer() && $conversation->customer_id !== $user->id) {
            abort(403);
        }
        if ($user->isProfessional() && $conversation->professional_id !== $user->id) {
            abort(403);
        }

        return response()->json($conversation->messages()->with('sender')->get());
    }
}
