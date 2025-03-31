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
        'question_count',
        'answer_time',
        'is_public',
        'password',
        'is_ai',
        'status',
        'max_players',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'is_ai' => 'boolean',
        'max_players' => 'integer',
    ];

    public static function boot(): void
    {
        parent::boot();

        static::saving(static function (Room $room) {
            if ($room->max_players < 2 || $room->max_players > 4) {
                throw new InvalidArgumentException('Количество игроков должно быть от 2 до 4');
            }

            if ($room->question_count < 5 || $room->question_count > 30) {
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