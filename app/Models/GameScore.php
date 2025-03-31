<?php

namespace App\Models;

use Database\Factories\GameScoreFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameScore extends Model
{
    /** @use HasFactory<GameScoreFactory> */
    use HasFactory;

    protected $table = 'game_scores';
    protected $fillable = ['game_id', 'user_id', 'score', 'rank'];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}