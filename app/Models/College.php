<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class College extends Model
{
    protected $fillable = [
        'name',
        'code'
    ];

    // Direct Relation
    public function buildings(): HasMany
    {
        return $this->hasMany(Building::class);
    }

    // Through Level 1: College -> Building -> Floor
    public function floors(): HasManyThrough
    {
        return $this->hasManyThrough(
            Floor::class,
            Building::class,
            'college_id',
            'building_id'
        );
    }
}
