<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Building extends Model
{
    protected $fillable = [
        'name',
        'code',

        // Operating Hours
        'start_time',
        'end_time',

        'college_id'
    ];

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    public function floors(): HasMany
    {
        return $this->hasMany(Floor::class);
    }

    public function rooms(): HasManyThrough
    {
        return $this->hasManyThrough(
            Room::class,
            Floor::class,
            'building_id',
            'floor_id'
        );
    }
        
}
