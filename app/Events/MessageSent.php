<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public string $username,
        public string $message,
        public string $timestamp,
    ) {}

    /**
     * The channel(s) this event broadcasts on.
     * "chat" is a public channel — anyone can subscribe.
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('chat'),
        ];
    }

    /**
     * The event name the JS client listens for.
     * Defaults to "App\Events\MessageSent" if you don't override this.
     */
    public function broadcastAs(): string
    {
        return 'message.sent';
    }
}
