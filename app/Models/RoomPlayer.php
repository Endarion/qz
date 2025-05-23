<?php

namespace App\Models;

use Database\Factories\RoomPlayerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomPlayer extends Model
{
    /** @use HasFactory<RoomPlayerFactory> */
    use HasFactory;

    protected $table = 'room_players';
    protected $fillable = ['room_id', 'user_id', 'joined_at'];
    protected array $dates = ['joined_at'];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}