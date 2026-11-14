<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// Room Assignment is basically a Schedule
class RoomAssignment extends Model
{
    protected $fillable = [
        'school_year',
        'semester',
        'is_active',

        // Schedule
        'day_of_week',
        'start_time',
        'end_time',
        
        // Foreign Keys
        'room_id',
        'professor_id'
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function professor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'professor_id');
    }
}
