<?php

namespace App\Http\Controllers;

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

        return Inertia::render('Rooms/Index', ['rooms' => $rooms->toArray()]);
    }

    public function store(Request $request): JsonResponse
    {
        $room = $this->roomService->createRoom(
            $request->only(['name', 'is_public', 'password', 'max_players', 'is_ai', 'category_id', 'question_count', 'answer_time']),
            auth()->user()
        );

        return response()->json([$room->id]);
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