<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserTyping implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public string $username,
        public bool $isTyping,
    ) {}

    public function broadcastOn(): array
    {
        return [new Channel('chat')];
    }

    public function broadcastAs(): string
    {
        return 'user.typing';
    }
}
