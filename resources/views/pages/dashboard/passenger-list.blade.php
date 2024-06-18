<?php

use App\Enums\RouteStatus;
use App\Helpers\Helper;
use App\Models\Passenger;
use Livewire\Attributes\On;
use Livewire\Volt\Component;

new class extends Component {
    public $passengers;
    public $driver;

    public function mount(): void
    {
        $this->driver = auth()->user()->driver->id;
        $this->passengers = Passenger::whereDriverId($this->driver)
            ->get();
    }

    #[On('echo:save-location,SaveLocation')]
    public function listernPassengerAdded($data): void
    {
        $this->mount();
    }

    #[On('locationFetched')]
    public function updateLocation($latitude, $longitude): void
    {
        Helper::updateUserLocation($latitude, $longitude);
    }

}; ?>

<div>
    <!-- start::Inbox -->
    <div class="w-full bg-white shadow-xl rounded-lg flex overflow-x-auto custom-scrollbar">
        <div class="w-64 px-4">
            <div class="px-2 pt-4 pb-8 border-r border-gray-300">
                <ul class="space-y-2">
                    <li>
                        <a class="bg-gray-500 bg-opacity-30 text-primary flex items-center justify-between py-1.5 px-4 rounded cursor-pointer">
                            <span class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="size-6">
                                  <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m15 15-6 6m0 0-6-6m6 6V9a6 6 0 0 1 12 0v3"/>
                                </svg>

                                <span>Requests</span>
                            </span>
                            <span class="bg-sky-500 text-gray-100 font-bold px-2 py-0.5 text-xs rounded-lg">{{ $this->passengers->count() ?? 0 }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="flex-1 px-2" x-data="{ checkAll: false, filterMessages: false }">
            <div class="h-16 flex items-center justify-between">
                <div class="flex items-center">

                    <div class="flex items-center">
                        <div class="flex items-center ml-3">
                            <a href="{{ route('dashboard') }}" wire:navigate>
                                <button title="Reload"
                                        class="text-gray-700 px-2 py-1 border border-gray-300 rounded-lg shadow hover:bg-gray-200 transition duration-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                </button>
                            </a>
                        </div>
                        <span class="bg-gray-300 h-6 w-[.5px] mx-3">refresh</span>
                    </div>
                </div>
            </div>
            <div class="bg-gray-100 mb-6">
                <ul>
                    @if($passengers->count() > 0)
                        @php $sno = 1 @endphp
                        @foreach($passengers as $passenger)
                            <li class="flex items-center border-y hover:bg-gray-200 px-2">
                                <span class="mr-1">{{ $sno++ }}</span>
                                <a href="{{ route('passengers.view', encrypt($passenger->id)) }}" wire:navigate>
                                    <div class="w-full flex items-center justify-between p-1 my-1 cursor-pointer"
                                    >
                                        <div class="flex items-center">
                                            <span class="w-56 pr-2 truncate">{{ $passenger->user->name }}</span>
                                            <span class="w-64 truncate">{{ $passenger->user->name }}</span>
                                            <span class="w-64 truncate {{ $passenger->status === RouteStatus::ABORTED ? 'text-red-400' : 'text-gray-500' }}">{{ $passenger->status }}</span>
                                        </div>
                                        <div class="w-32 flex items-center justify-end">
                                            <span class="text-sm text-gray-500">
                                                {{ $passenger->created_at->format('H:i A') }}
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    @else
                        ~
                        <span class="w-full truncate">No passenger requested</span>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <!-- end::Inbox -->
</div>

@push('scripts')
    <script>
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

        setInterval(function () {
            getLocationAndPopulateFields();
        }, 1000)
    </script>
@endpush
