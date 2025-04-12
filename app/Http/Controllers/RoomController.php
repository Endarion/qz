<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Room;
use App\Services\RoomService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RoomController extends Controller
{
    public function __construct(private readonly RoomService $roomService)
    {
    }

    public function index(): Response
    {
        $rooms = $this->roomService->all();
        $categories = Category::all();

        return Inertia::render('Rooms/Index', [
            'rooms' => $rooms->map(function (Room $room) {
                return [
                    'id' => $room->id,
                    'name' => $room->name,
                    'status' => $room->status,
                    'host_id' => $room->host_id,
                    'players_count' => $room->players_count,
                    'questions_count' => $room->questions_count ?? 0,
                    'category' => [
                        'id' => $room->category_id,
                        'name' => $room->category->name,
                        'icon' => $room->category->icon,
                    ],
                    'players' => $room->players->map(function ($player) {
                        return [
                            'id' => $player->id,
                            // @todo при регистрации сделать username, сделать авторизации через сети
                            'username' => $player->name,
                        ];
                    })->all(),
                ];
            })->all(),
            'categories' => $categories->map(function (Category $category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'icon' => $category->icon,
                ];
            })->all(),
        ]);
    }

    public function store(Request $request): Response
    {
        // todo перенести в форм реквесты
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'is_public' => 'boolean',
            'password' => 'required_if:is_public,false|string|nullable|min:4|max:4',
            'players_count' => 'required|integer|min:2|max:4',
            'questions_count' => 'required|integer|min:5|max:30',
            'category_id' => 'required|integer|exists:categories,id',
            'answer_time' => 'required|integer|min:10|max:30',
        ]);

        $room = $this->roomService->createRoom($validated, auth()->user());

        return inertia('Rooms/Show', [
            'room_id' => $room->id,
        ]);
    }

    public function show(Room $room): Response
    {
        $room->load('players', 'host');
        return Inertia::render('Rooms/Show', ['room' => $room->toArray()]);
    }

    public function join(Request $request, Room $room): JsonResponse
    {
        $this->roomService->joinRoom($room, auth()->user(), $request->input('password'));
        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function start(Room $room): JsonResponse
    {
        $this->roomService->startGame($room, auth()->user());
        return response()->json(['success' => true]);
    }
}
