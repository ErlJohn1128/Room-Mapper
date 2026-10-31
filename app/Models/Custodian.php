<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Custodian extends Model
{
    protected $fillables = [
        'name',
        'code',
        'location'
    ];

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }
}
