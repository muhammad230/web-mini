<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    public const DELETE_EVERYONE_WINDOW_MINUTES = 10;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'sender_role',
        'message_text',
        'is_read',
        'deleted_for_sender',
        'deleted_for_recipient',
        'deleted_for_everyone',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
            'deleted_for_sender' => 'boolean',
            'deleted_for_recipient' => 'boolean',
            'deleted_for_everyone' => 'boolean',
        ];
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function scopeVisibleTo($query, User $user)
    {
        return $query->where(function ($q) use ($user) {
            $q->where(function ($own) use ($user) {
                $own->where('sender_id', $user->id)->where('deleted_for_sender', false);
            })->orWhere(function ($other) use ($user) {
                $other->where('sender_id', '!=', $user->id)->where('deleted_for_recipient', false);
            });
        });
    }

    public function textFor(User $user): string
    {
        if ($this->deleted_for_everyone) {
            return 'This message was deleted';
        }

        return $this->message_text;
    }
}
