<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Group extends Model
{
    protected $fillable = ['name', 'code', 'owner_id', 'current_min_bet'];

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
        return $this->belongsToMany(User::class);
    }

    public function predictions(): HasMany
    {
        return $this->hasMany(Prediction::class);
    }
}
