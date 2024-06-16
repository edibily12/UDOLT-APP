<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'driver_id', 'distance', 'amount', 'destination'
    ];

    public static function getSummary($driverId): array
    {
        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();
        $startOfYear = Carbon::now()->startOfYear();

        $summary = DB::table('payments')
            ->select(
                DB::raw('SUM(amount) as total_amount'),
                DB::raw('SUM(CASE WHEN created_at >= ? THEN amount ELSE 0 END) as amount_today'),
                DB::raw('SUM(CASE WHEN created_at >= ? THEN amount ELSE 0 END) as amount_this_week'),
                DB::raw('SUM(CASE WHEN created_at >= ? THEN amount ELSE 0 END) as amount_this_month'),
                DB::raw('SUM(CASE WHEN created_at >= ? THEN amount ELSE 0 END) as amount_this_year')
            )
            ->where('driver_id', $driverId)
            ->addBinding([$today, $startOfWeek, $startOfMonth, $startOfYear], 'select')
            ->first();

        return (array) $summary;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }
}
