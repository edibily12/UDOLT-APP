<?php

use App\Enums\PassengerStatus;
use App\Enums\RouteStatus;
use App\Helpers\Helper;
use App\Models\Driver;
use App\Models\Passenger;
use App\Models\Places;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Http;

new class extends Component {
    public $allPlaces = [], $nearestDrivers, $distances;

    public $latitude;
    public $longitude;
    public $destinationDistance;
    #[Rule('required')]
    public $destination;
    public $driverID;
    public $passengerExist;

    public $userLat, $userLong;

    public function mount(): void
    {
        auth()->user()->isPassenger() ? '' : abort(403, 'Not Authorized to Access This Page');
        $user_id = auth()->user()->id;

        $this->userLat = auth()->user()->latitude;
        $this->userLong = auth()->user()->longitude;

        $this->allPlaces = Places::all();
        $this->passengerExist = Passenger::whereUserId($user_id)->exists();
    }


    public function confirmOrCancelRoute(Passenger $passenger): void
    {
        $passenger->confirmed = !$passenger->confirmed;
        $passenger->status = RouteStatus::ABORTED->value;
        $passenger->save();
        $this->dispatch('cancel-route');
        $this->mount();
    }

    public function updatedDestination(): void
    {
        $this->updateMap();
    }

    public function updateMap(): void
    {
        if ($this->destination) {
            $selectedPlace = $this->allPlaces->firstWhere('id', $this->destination);
            if ($selectedPlace) {
                $this->destinationDistance = Helper::haversineGreatCircleDistance(
                    $this->userLat,
                    $this->userLong,
                    $selectedPlace->latitude,
                    $selectedPlace->longitude
                );

//                dd($this->destinationDistance);
//
//                $this->userLat = $selectedPlace->latitude;
//                $this->userLong = $selectedPlace->longitude;
            }
        }
    }

    #[On('echo:toggle-route,ConfirmRoute')]
    public function confirmRoute(): void
    {
        $this->mount();
    }

    #[On('locationFetched')]
    public function sendLocation($latitude, $longitude): void
    {
        $user_id = auth()->user()->id;
        $driver = Driver::findOrFail($this->driverID);

        \App\Jobs\SaveLocation::dispatch($latitude, $longitude, $driver->id, $user_id, $this->destination)
            ->delay(now()->addSeconds(5));

        $this->dispatch('location-saved', $driver->user->name);
        redirect()->route('dashboard');
    }

    #[On('locFetched')]
    public function updateLocation($latitude, $longitude): void
    {
        Helper::updateUserLocation($latitude, $longitude);
    }

    public function sendRequest($driverId): void
    {
        $this->driverID = $driverId;
        $this->dispatch('getPassengerLocation');
    }

    public function findNearestDrivers(int $numberOfDrivers = 3): void
    {
        $this->validate();
        $availableDrivers = \App\Models\Driver::with(['user', 'vehicle'])->get();

        if ($availableDrivers->count() > 0) {
            $nearestDrivers = collect();
            $distances = [];

            foreach ($availableDrivers as $driver) {
                if ($driver->user->latitude === null || $driver->user->longitude === null) {
                    $this->dispatch("error-occurred");
                    return;
                }
                $distance = Helper::haversineGreatCircleDistance(
                    $this->userLat,
                    $this->userLong,
                    $driver->user->latitude,
                    $driver->user->longitude
                );

                // Add distance to the distances array
                $distances[$driver->id] = $distance;
            }

            // Sort distances in ascending order
            asort($distances);

            // Get the nearest drivers
            $nearestDriverIds = array_slice(array_keys($distances), 0, $numberOfDrivers);

            foreach ($nearestDriverIds as $driverId) {
                $nearestDriver = $availableDrivers->where('id', $driverId)->first();
                $nearestDrivers->push($nearestDriver);
            }

            // Assign nearest drivers and distances
            $this->nearestDrivers = $nearestDrivers;
            $this->distances = array_intersect_key($distances, array_flip($nearestDriverIds));
        } else {
            $this->dispatch('no-driver');
        }
    }

}; ?>

<div>
    <div class="pt-1">

        @if($nearestDrivers)
            <div class="bg-white rounded-lg shadow-xl p-8">
                <div class="flex items-center justify-between">
                    <h4 class="text-xl text-gray-900 font-bold">Drivers ({{ $nearestDrivers->count() }})</h4>
                    <a href="#" title="View All">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500 hover:text-gray-700"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/>
                        </svg>
                    </a>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-8 gap-8 mt-8">
                    @foreach ($nearestDrivers as $nearestDriver)
                        <a href="#" wire:confirm.prompt="Confirm request.Type YES to confirm|YES"
                           wire:click="sendRequest({{ $nearestDriver->id }})"
                           class="flex flex-col items-center justify-center text-gray-800 hover:text-primary"
                           title="send request">
                            <img src="{{ Storage::url('files/images/logo.png') }}" class="w-16 rounded-full">
                            <p class="text-center font-bold text-sm mt-1">{{ $nearestDriver->user->name }}</p>
                            <p class="text-xs text-gray-500 text-center">{{ $nearestDriver->user->phone }}</p>
                            <p class="text-xs text-gray-500 text-center">{{ $nearestDriver->user->email }}</p>
                            <p class="text-xs text-gray-500 text-center">{{ $nearestDriver->vehicle->type ?? "N/A" }}</p>
                            <p class="text-center font-bold text-sm mt-1">
                                {{ round($distances[$nearestDriver->id]). " KM AWAY" }}
                            </p>
                        </a>
                    @endforeach
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-xl p-8">
                @php
                    $user_id = auth()->user()->id;
                    $pass = Passenger::whereUserId($user_id)->first();
                @endphp
                @if($passengerExist && $pass->confirmed)
                    <div
                            class="flex flex-col items-center justify-center text-gray-800 hover:text-primary"
                            title="send request">
                        <img src="{{ Storage::url('files/images/logo.png') }}" class="w-16 rounded-full">
                        <p class="text-center font-bold text-sm mt-1">{{ $pass->driver->user->name }}</p>
                        <p class="text-xs text-gray-500 text-center">{{ $pass->driver->user->phone }}</p>
                        <p class="text-xs text-gray-500 text-center">{{ $pass->driver->nida }}</p>
                        <p class="text-xs text-gray-500 text-center">{{ $pass->driver->license_number }}</p>
                        <p class="text-center font-bold text-sm mt-1">
                            {{ $pass->driver->vehicle->type }}
                        </p>
                        @php $authPassenger = auth()->user()->passenger->id @endphp
                        <x-buttons.primary wire:click="confirmOrCancelRoute({{ $authPassenger }})"
                                           class="cursor-pointer my-2" title="cancel route">Cancel
                        </x-buttons.primary>
                    </div>
                @else
                    <form wire:submit.prevent="findNearestDrivers" class="mb-8">
                        <div class="grid grid-cols-1 gap-4">
                            <div class="flex flex-col my-4">
                                <x-label class="dark:text-gray-800" for="form" value="{{ __('Where To') }}"/>
                                <select class="block mt-1 w-full capitalize border-gray-300 focus:border-indigo-500 dark:text-gray-800 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm py-4"
                                        wire:model="destination"
                                        wire:change="updateMap"
                                >
                                    <option value="">--Select Destination--</option>
                                    @foreach($allPlaces as $place)
                                        <option value="{{ $place->id }}">{{ $place->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error for="destination"/>
                            </div>
                        </div>

                        @if($destinationDistance)
                            <div id="alert-border-3"
                                 class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 "
                                 role="alert">
                                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                </svg>
                                <div class="ms-3 text-sm font-medium">
                                    Destination distance: <strong>{{ ceil($destinationDistance) }} </strong>
                                </div>
                                <div class="ms-3 text-sm font-medium">
                                    Cost: <strong>Tsh: {{ number_format(ceil($destinationDistance)*1000) }} </strong>
                                </div>
                            </div>
                        @endif


                        <x-buttons.success class="mb-4">
                            {{ __('FIND DRIVER') }}
                        </x-buttons.success>
                    </form>

                @endif

                <div class="flex items-center justify-between">
                    <h4 class="text-xl text-gray-900 font-bold">
                        Your Location
                    </h4>
                </div>
                <div class="w-full">
                    <!-- start:: Markers Map -->
                    <div class="my-2" style="height: 600px;">
                        <iframe
                                id="mapFrame"
                                src="https://www.google.com/maps/embed/v1/place?key=AIzaSyD94Nn1uj4OJxhpy7UPW6vFp-xAPj9TqR0&q={{ $userLat }},{{ $userLong }}&zoom=15"
                                class="left-0 top-0 h-full w-full rounded-t-lg lg:rounded-tr-none lg:rounded-bl-lg"
                                frameborder="0"
                                allowfullscreen>
                        </iframe>
                    </div>
                    <!-- end:: Markers Map -->
                </div>
            </div>
        @endif

    </div>
</div>

@push('scripts')
    <script>

        Livewire.on('cancel-route', function () {
            swal('Good Job', 'Route canceled successfully', 'success')
        })

        Livewire.on('getPassengerLocation', function (driverId) {
            getLocationAndPopulateFields(driverId);
        });

        Livewire.on('no-driver', function () {
            swal({
                title: "warning",
                text: "Request sent successfully, but no driver found.",
                icon: "warning",
                button: "OK"
            });
        });

        Livewire.on('location-saved', function (name) {
            swal({
                title: "Successfully",
                text: "Request sent successfully, your driver " + name + " will be there soon.",
                icon: "success",
                button: "OK"
            });
        });

        Livewire.on('error-occurred', function () {
            swal({
                title: "Something went wrong",
                text: "An error occurred please contact an Admin!",
                icon: "error",
            });
        });

        function getLocationAndPopulateFields() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var latitude = position.coords.latitude;
                    var longitude = position.coords.longitude;

                    Livewire.dispatch('locationFetched', {latitude: latitude, longitude: longitude});

                }, function (error) {
                    console.error("Error fetching location:", error);
                });
            } else {
                console.error("Geolocation is not supported by this browser.");
            }
        }

        //auto update passenger location
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var latitude = position.coords.latitude;
                    var longitude = position.coords.longitude;

                    Livewire.dispatch('locFetched', {latitude: latitude, longitude: longitude});

                }, function (error) {
                    console.error("Error fetching location:", error);
                });
            } else {
                console.error("Geolocation is not supported by this browser.");
            }
        }

        // setInterval(function () {
        //     getLocation()
        // }, 10000)

    </script>
@endpush

