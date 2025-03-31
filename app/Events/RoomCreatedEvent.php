<?php

namespace App\Events;

use App\Models\Room;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;

class RoomCreatedEvent
{
    use InteractsWithSockets;

    public function __construct(public readonly Room $room)
    {
    }

    public function broadcastOn(): Channel
    {
        return new Channel('room');
    }

    public function broadcastWith(): array
    {
        return [
            'room' => [
                'id' => $this->room->id,
                'name' => $this->room->name,
                'status' => $this->room->status,
                'questions_count' => $this->room->questions_count,
                'players_count' => $this->room->players_count,
                'is_ai' => $this->room->is_ai,
            ],
        ];
    }
}