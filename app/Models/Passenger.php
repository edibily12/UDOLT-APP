<?php

namespace App\Models;

use App\Enums\RouteStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Passenger extends Model
{
    use HasFactory;

//    use SoftDeletes;

    public $timestamps = true;

    protected $fillable = [
        'user_id', 'driver_id', 'latitude', 'longitude', 'destination'
    ];

    protected $casts = [
        'status' => RouteStatus::class,
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function place(): BelongsTo
    {
        return $this->belongsTo(Places::class);
    }


}
