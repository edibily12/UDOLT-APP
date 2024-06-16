<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', 'driver_id', 'type', 'vehicle_no'
    ];

    //search vehicle
    public static function search($search = '')
    {
        return empty($search) ? static::query() : static::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('type', 'LIKE', "%{$search}%")
            ->orWhere('vehicle_no', 'LIKE', "%{$search}%");
    }

    /*******************************/
    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }
}
