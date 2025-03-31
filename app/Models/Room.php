<?php

namespace App\Models;

use Database\Factories\RoomFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use InvalidArgumentException;

class Room extends Model
{
    /** @use HasFactory<RoomFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'host_id',
        'category_id',
        'questions_count',
        'answer_time',
        'is_public',
        'password',
        'is_ai',
        'status',
        'players_count',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'is_ai' => 'boolean',
        'players_count' => 'integer',
    ];

    public static function boot(): void
    {
        parent::boot();

        static::saving(static function (Room $room) {
            if ($room->players_count < 2 || $room->players_count > 4) {
                throw new InvalidArgumentException('Количество игроков должно быть от 2 до 4');
            }

            if ($room->questions_count < 5 || $room->questions_count > 30) {
                throw new InvalidArgumentException('Количество вопросов должно быть от 5 до 30');
            }
        });
    }

    public function host(): BelongsTo
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    public function players(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'room_players')
            ->withTimestamps()
            ->withPivot('joined_at');
    }

    public function games(): HasMany
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