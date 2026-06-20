<?php

namespace App\Models;

use App\Enums\MessageRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Message extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['conversation_id', 'role', 'content', 'tool_calls'];

    protected $casts = [
        'role' => MessageRole::class,
        'tool_calls' => 'array',
        'created_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Message $message) {
            if (is_null($message->created_at)) {
                $message->created_at = Carbon::now();
            }
        });
    }

    /**
     * Get the conversation that owns the message.
     */
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }
}
