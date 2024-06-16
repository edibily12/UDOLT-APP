<?php

namespace App\Helpers;

use App\Models\Payment;
use Carbon\Carbon;
use Exception;

class Helper
{
    //manage route files
    public static function includeRoutes($folder): void
    {
        //loop recursively to the web folder;
        $directory = new \RecursiveDirectoryIterator($folder);

        /** @var \RecursiveDirectoryIterator | \RecursiveIteratorIterator $iterator */
        $iterator = new \RecursiveIteratorIterator($directory);

        //require files inside web directory
        while ($iterator->valid()) {
            //check if the file exist then require that file
            if (!$iterator->isDot() && $iterator->isFile() && $iterator->isReadable() && $iterator->current()->getExtension() === 'php') {
                require $iterator->key();
            }

            $iterator->next();
        }
    }

    //calculate delay time
    public static function calculateDelaySeconds($dateToString, $time): int
    {
        $dateTimeString = $dateToString . ' ' . $time;

        $dateTime = \Carbon\Carbon::parse($dateTimeString);

        $currentTime = \Carbon\Carbon::now();

        $minutesDifference = $currentTime->diffInMinutes($dateTime);

        return round($minutesDifference) * 60;
    }

    //Calculation of distance btn 2 points Using Haversine Formula:
    public static function haversineGreatCircleDistance(
        float $latitudeFrom, float $longitudeFrom,
        float $latitudeTo, float $longitudeTo,
        float $earthRadius = 6371.0): float
    {
        // Convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt((sin($latDelta / 2) ** 2) +
                cos($latFrom) * cos($latTo) * (sin($lonDelta / 2) ** 2)));
        return $angle * $earthRadius;

    }

    //update user location
    public static function updateUserLocation($latitude, $longitude): void
    {
        $user = auth()->user();
        try {
            $user->update([
                'latitude' => $latitude,
                'longitude' => $longitude
            ]);
        } catch (Exception $e) {
            echo "Error: ";
        }
    }

    //today's routes
    public static function todayRoutes($driverId)
    {
        return Payment::where('driver_id', $driverId)
            ->whereDate('created_at', Carbon::today())
            ->get();
    }

}