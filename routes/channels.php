<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {
    $conversation = \App\Models\Conversation::find($conversationId);

    if (!$conversation) {
        return false;
    }

    return (int) $conversation->customer_id === (int) $user->id
        || (int) $conversation->professional_id === (int) $user->id
        ? ['id' => $user->id, 'name' => $user->name]
        : false;
});
