<?php

namespace App\Models;

use Database\Factories\GameQuestionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameQuestion extends Model
{
    /** @use HasFactory<GameQuestionFactory> */
    use HasFactory;

    protected $table = 'game_questions';
    protected $fillable = ['game_id', 'question_id', 'order'];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}