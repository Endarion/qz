<?php

namespace App\Models;

use Database\Factories\GameFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    /** @use HasFactory<GameFactory> */
    use HasFactory;

    protected $fillable = ['room_id', 'started_at', 'finished_at', 'category_id', 'status'];
    protected array $dates = ['started_at', 'finished_at'];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'game_question')
            ->withPivot(['order']);
    }

    public function players(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'game_scores')
            ->withPivot('score', 'rank');
    }

    public function playerAnswers(): HasMany
    {
        return $this->hasMany(PlayerAnswer::class);
    }

    public function scores(): HasMany
    {
        return $this->hasMany(GameScore::class);
    }
}