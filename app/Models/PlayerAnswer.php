<?php

namespace App\Models;

use Database\Factories\PlayerAnswerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlayerAnswer extends Model
{
    /** @use HasFactory<PlayerAnswerFactory> */
    use HasFactory;

    protected $fillable = ['game_id', 'user_id', 'question_id', 'answer_id', 'is_correct', 'answered_at'];
    protected $casts = ['is_correct' => 'boolean'];
    protected array $dates = ['answered_at'];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function answer(): BelongsTo
    {
        return $this->belongsTo(Answer::class);
    }
}