<?php

namespace App\Models;

use Database\Factories\CourseFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $city
 * @property int $holes
 */
#[Fillable(['name', 'city', 'holes'])]
class Course extends Model
{
    /** @use HasFactory<CourseFactory> */
    use HasFactory;

    /**
     * @return HasMany<TeeTime, $this>
     */
    public function teeTimes(): HasMany
    {
        return $this->hasMany(TeeTime::class);
    }
}
