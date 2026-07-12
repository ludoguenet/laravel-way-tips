<?php

namespace App\Models;

use Database\Factories\BookingFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $golfer_id
 * @property int $tee_time_id
 * @property int $players
 * @property Carbon|null $cancelled_at
 */
#[Fillable(['golfer_id', 'tee_time_id', 'players', 'cancelled_at'])]
class Booking extends Model
{
    /** @use HasFactory<BookingFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'cancelled_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function golfer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'golfer_id');
    }

    /**
     * @return BelongsTo<TeeTime, $this>
     */
    public function teeTime(): BelongsTo
    {
        return $this->belongsTo(TeeTime::class);
    }
}
