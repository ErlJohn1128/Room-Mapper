<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Floor extends Model
{
    protected $fillable = [
        'name',
        'code',
        'building_id'
    ];

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    } 

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }
}
