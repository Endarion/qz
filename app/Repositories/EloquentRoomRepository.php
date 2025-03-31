<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Room;
use Illuminate\Support\Collection;

class EloquentRoomRepository implements RoomRepositoryInterface
{
    public function find(int $id): ?Room
    {
        return Room::find($id);
    }

    public function create(array $data): Room
    {
        return Room::create($data);
    }

    public function update(Room $room): void
    {
        $room->save();
    }

    public function all(): Collection
    {
        return Room::all();
    }
}