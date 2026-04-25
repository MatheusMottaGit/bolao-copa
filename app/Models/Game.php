<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    protected $fillable = ['api_id', 'home_team', 'away_team', 'starts_at', 'home_score', 'away_score', 'status'];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'home_score' => 'integer',
            'away_score' => 'integer',
        ];
    }

    public function predictions(): HasMany
    {
        return $this->hasMany(Prediction::class);
    }

    public function isOpen(): bool
    {
        return $this->status === 'scheduled';
    }
}
