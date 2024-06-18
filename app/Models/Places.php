<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Places extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'latitude', 'longitude',
    ];

    public function passengers(): HasMany
    {
        return $this->hasMany(Passenger::class);
    }
}
