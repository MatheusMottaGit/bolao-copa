<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Group extends Model
{
    protected $fillable = ['name', 'code', 'owner_id', 'buy_in'];

    /** Fração do bolo destinada a cada posição do pódio (1º, 2º, 3º). */
    public const PRIZE_SPLIT = [0.70, 0.20, 0.10];

    protected function casts(): array
    {
        return [
            'buy_in' => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Group $group) {
            if (empty($group->code)) {
                do {
                    $code = strtoupper(Str::random(6));
                } while (static::where('code', $code)->exists());

                $group->code = $code;
            }
        });
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('bet_amount');
    }

    public function predictions(): HasMany
    {
        return $this->hasMany(Prediction::class);
    }

    /** Soma de todas as apostas registradas (o bolo total). */
    public function pot(): float
    {
        return (float) $this->users()->sum('bet_amount');
    }

    /** Valor do prêmio para cada posição do pódio, a partir do bolo total. */
    public function prizes(): array
    {
        $pot = $this->pot();

        return array_map(fn ($fraction) => round($pot * $fraction, 2), self::PRIZE_SPLIT);
    }
}
