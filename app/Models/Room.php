<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'name',
        'code',
        'room_type',
        
        // Foreign Keys
        'floor_id',
        'custodian_id',

        'is_available',

        // Specifications
        'equipment',
        'power_outlets',
        'fans',
        'air_conditioners',
        'other'
    ];

    protected function casts(): array
    {
        return [
            'is_available' => 'boolean',
            'equipment' => 'array'
        ];
    }
}
