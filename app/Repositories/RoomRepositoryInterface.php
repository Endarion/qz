<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Room;
use Illuminate\Support\Collection;

interface RoomRepositoryInterface
{
    public function find(int $id): ?Room;

    public function create(array $data): Room;

    public function update(Room $room): void;

    public function all(): Collection;
}