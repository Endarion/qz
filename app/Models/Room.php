<?php

namespace App\Models;

use Database\Factories\RoomFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Room extends Model
{
    /** @use HasFactory<RoomFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'host_id',
        'category_id',
        'question_count',
        'answer_time',
        'is_public',
        'password',
        'is_ai',
        'status',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'is_ai' => 'boolean',
    ];

    public function host(): BelongsTo
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    public function players()
    {
        return $this->belongsToMany(User::class, 'room_players')
            ->withTimestamps()
            ->withPivot('joined_at');
    }

    public function games()
    {
        return $this->hasMany(Game::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function startGame(): void
    {
        // todo enum
        $this->update(['status' => 'playing']);
    }
}