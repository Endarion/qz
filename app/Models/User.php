<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'premium_expires_at',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'premium_expires_at' => 'datetime',
        ];
    }

    public function roomsHosted(): HasMany
    {
        return $this->hasMany(Room::class, 'host_id');
    }

    public function rooms(): HasMany
    {
        return $this->belongsToMany(Room::class, 'room_players')
            ->withTimestamps()
            ->withPivot('joined_at');
    }

    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class, 'game_scores')
            ->withPivot('score', 'rank');
    }

    public function playerAnswers(): HasMany
    {
        return $this->hasMany(PlayerAnswer::class);
    }

    public function isPremium(): bool
    {
        return $this->premium_expires_at && now()->lt($this->premium_expires_at);
    }
}