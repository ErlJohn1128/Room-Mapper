<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'for_use',

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
            'for_use' => 'boolean',
            'equipment' => 'array'
        ];
    }

    public function floor(): BelongsTo
    {
        return $this->belongsTo(Floor::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(RoomAssignment::class);
    }
}
