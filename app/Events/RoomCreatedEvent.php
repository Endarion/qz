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
                'question_count' => $this->room->question_count,
                'max_players' => $this->room->max_players,
                'is_ai' => $this->room->is_ai,
            ],
        ];
    }
}