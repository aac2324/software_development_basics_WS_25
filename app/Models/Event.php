<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    /** @use HasFactory<\Database\Factories\EventFactory> */
    use HasFactory;

    protected $guarded = [];

    public function host(): BelongsTo
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'event_id');
    }

    public function canEditOrDelete(User $user): bool
    {
        // Admin users can always edit and delete all events
        if($user->isAdmin()) {
            return true;
        }

        // Only the host can delete or edit his/her event
        if($this->host_id !== $user->id) {
            return false;
        }

        return true;
    }

    public function averageRating(): float
    {
    return round($this->reviews()->avg('rating'), 1);
    }
};