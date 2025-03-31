<?php

namespace App\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
    ];

    public function question(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function games()
    {
        return $this->hasMany(Game::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}