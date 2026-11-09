<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PresensiNotificationEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public int $userId,
        public array $notifikasi
    ) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->userId),
            new Channel('public-presensi-user-' . $this->userId),
        ];
    }

    public function broadcastAs(): string
    {
        return 'PresensiNotificationEvent';
    }

    public function broadcastWith(): array
    {
        return [
            'userId' => $this->userId,
            'notifikasi' => $this->notifikasi,
        ];
    }
}

