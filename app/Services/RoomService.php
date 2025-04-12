<?php

namespace App\Services;

use App\Events\RoomCreatedEvent;
use App\Models\Room;
use App\Models\User;
use App\Repositories\RoomRepositoryInterface;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Event;

readonly class RoomService
{
    public function __construct(private RoomRepositoryInterface $roomRepository)
    {
    }

    public function createRoom(array $data, User $host): Room
    {
        $room = $this->roomRepository->create([
            'name' => $data['name'],
            'host_id' => $host->id,
            'is_public' => $data['is_public'] ?? true,
            'password' => $data['is_public'] ? null : $data['password'],
            'players_count' => $data['players_count'],
            // todo статусы вынести в enum?
            'status' => 'waiting',
            'questions_count' => $data['questions_count'],
            'category_id' => $data['category_id'],
            'answer_time' => $data['answer_time'],
        ]);

        $room->players()->attach($host->id);

        Event::dispatch(new RoomCreatedEvent($room));

        return $room;
    }

    public function joinRoom(Room $room, User $user, ?string $password = null): void
    {
        if ($room->players()->count() >= $room->players_count) {
            throw new Exception('Комната заполнена');
        }

        if (!$room->is_public && $password !== $room->password) {
            throw new Exception('Неверный пароль');
        }

        $room->players()->attach($user->id);
    }

    public function leaveRoom(Room $room, User $user): void
    {
        $room->players()->detach($user->id);
    }

    public function startGame(Room $room, User $host): void
    {
        if ($room->host_id !== $host->id) {
            throw new Exception('Только хост может начать игру');
        }

        $room->status = 'playing';
        $this->roomRepository->update($room);
    }

    public function all(bool $publicOnly = true): Collection
    {
        $rooms = $this->roomRepository->all();

        return $publicOnly ? $rooms->where('is_public', true) : $rooms;
    }
}
