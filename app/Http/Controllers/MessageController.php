<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\CustomerJob;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch all conversations where this user is either the customer or the professional
        $conversations = Conversation::where(function($q) use ($user) {
                $q->where('customer_id', $user->id)
                  ->orWhere('professional_id', $user->id);
            })
            ->with(['customer', 'professional', 'job', 'lastMessage', 'quote'])
            ->latest()
            ->get();

        return view('messages.index', compact('conversations'));
    }

    public function show($id)
    {
        $user = Auth::user();
        $conversation = Conversation::with(['job', 'customer', 'professional', 'messages.sender'])->findOrFail($id);

        // Check if user is part of this conversation
        if ($user->isCustomer() && (int) $conversation->customer_id !== (int) $user->id) {
            abort(403);
        }
        if ($user->isProfessional() && (int) $conversation->professional_id !== (int) $user->id) {
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
        if ($user->isCustomer() && (int) $conversation->customer_id !== (int) $user->id) {
            abort(403);
        }
        if ($user->isProfessional() && (int) $conversation->professional_id !== (int) $user->id) {
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

        // Notify the recipient
        $recipientId = $user->isCustomer()
            ? $conversation->professional_id
            : $conversation->customer_id;

        Notification::create([
            'user_id'       => $recipientId,
            'type'          => 'new_message',
            'title'         => 'New message from ' . $user->name,
            'message'       => $user->name . ' sent you a message: "' . \Illuminate\Support\Str::limit($request->message_text, 80) . '"',
            'related_job_id'=> $conversation->job_id,
        ]);

        try {
            broadcast(new MessageSent($message));
        } catch (\Throwable $e) {
            report($e);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'message' => [
                    'id' => $message->id,
                    'conversation_id' => $message->conversation_id,
                    'sender_id' => $message->sender_id,
                    'sender_role' => $message->sender_role,
                    'sender_name' => $user->name,
                    'message_text' => $message->message_text,
                    'created_at' => $message->created_at ? $message->created_at->toDateTimeString() : null,
                    'created_at_human' => $message->created_at ? $message->created_at->format('g:i A • M j') : '',
                ],
            ], 201);
        }

        return back();
    }

    public function getOrCreate($jobId)
    {
        $user = Auth::user();
        $job = CustomerJob::findOrFail($jobId);

        if ($user->isCustomer() && $job->customer_id !== $user->id) {
            abort(403);
        }
        if ($user->isProfessional()) {
            // Professional must either be the assigned pro or have a quote on this job
            $hasQuote = DB::table('quotes')
                ->where('job_id', $jobId)
                ->where('pro_id', $user->id)
                ->exists();
            if (!$hasQuote && $job->assigned_pro_id !== $user->id) {
                abort(403);
            }
        }

        // For professionals, find their specific conversation for this job
        if ($user->isProfessional()) {
            $conversation = Conversation::where('job_id', $jobId)
                ->where('professional_id', $user->id)
                ->first();

            if ($conversation) {
                return redirect()->route('messages.show', $conversation->id);
            }

            // Fallback: create conversation for the assigned pro (backward compat)
            if ($job->assigned_pro_id && (int) $job->assigned_pro_id === (int) $user->id) {
                $conversation = Conversation::firstOrCreate(
                    ['job_id' => $job->id, 'professional_id' => $user->id],
                    [
                        'customer_id' => $job->customer_id,
                        'professional_id' => $user->id,
                    ]
                );
                return redirect()->route('messages.show', $conversation->id);
            }

            return back()->with('error', 'No conversation available for this job.');
        }

        // For customers: find the conversation for the accepted/active quote
        if ($job->assigned_pro_id) {
            $conversation = Conversation::where('job_id', $jobId)
                ->where('professional_id', $job->assigned_pro_id)
                ->first();

            if ($conversation) {
                return redirect()->route('messages.show', $conversation->id);
            }

            // Fallback: create conversation for the assigned pro
            $conversation = Conversation::firstOrCreate(
                ['job_id' => $job->id, 'professional_id' => $job->assigned_pro_id],
                [
                    'customer_id' => $job->customer_id,
                    'professional_id' => $job->assigned_pro_id,
                ]
            );
            return redirect()->route('messages.show', $conversation->id);
        }

        return back()->with('error', 'No professional assigned to this job yet.');
    }

    public function getOrCreateByQuote($quoteId)
    {
        $user = Auth::user();
        $quote = Quote::findOrFail($quoteId);
        $job = $quote->job;

        // Authorization: must be the customer who owns the job or the professional who sent the quote
        if ($user->isCustomer() && $job->customer_id !== $user->id) {
            abort(403);
        }
        if ($user->isProfessional() && $quote->pro_id !== $user->id) {
            abort(403);
        }

        $conversation = Conversation::firstOrCreate(
            ['job_id' => $job->id, 'quote_id' => $quote->id],
            [
                'customer_id'     => $job->customer_id,
                'professional_id' => $quote->pro_id,
            ]
        );

        return redirect()->route('messages.show', $conversation->id);
    }

    public function getUnreadCount()
    {
        $user = Auth::user();
        return response()->json(['count' => $user->unreadMessagesCount()]);
    }

    public function getMessages(Request $request, $conversationId)
    {
        $user = Auth::user();
        $conversation = Conversation::findOrFail($conversationId);

        if ($user->isCustomer() && (int) $conversation->customer_id !== (int) $user->id) {
            abort(403);
        }
        if ($user->isProfessional() && (int) $conversation->professional_id !== (int) $user->id) {
            abort(403);
        }

        $query = $conversation->messages()->with('sender');
        if ($request->has('after_id')) {
            $query->where('id', '>', (int) $request->after_id);
        }

        $messages = $query->get()->map(function ($msg) {
            return [
                'id' => $msg->id,
                'conversation_id' => $msg->conversation_id,
                'sender_id' => $msg->sender_id,
                'sender_role' => $msg->sender_role,
                'sender_name' => $msg->sender ? $msg->sender->name : null,
                'message_text' => $msg->message_text,
                'created_at' => $msg->created_at ? $msg->created_at->toDateTimeString() : null,
                'created_at_human' => $msg->created_at ? $msg->created_at->format('g:i A • M j') : '',
            ];
        });

        return response()->json($messages);
    }
}
