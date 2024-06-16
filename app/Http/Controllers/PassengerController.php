<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PassengerController extends Controller
{
    public function fetchLocation(Request $request): void
    {

        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        // Now you can use $latitude and $longitude in your controller logic
    }
}
