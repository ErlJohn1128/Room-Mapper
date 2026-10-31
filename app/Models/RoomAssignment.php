<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'user_id'
    ];
}
