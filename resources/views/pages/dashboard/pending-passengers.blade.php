<?php

use App\Enums\RouteStatus;
use App\Models\Passenger;
use App\Models\Places;
use Livewire\Volt\Component;

new class extends Component {
    public $passengers;

    public function mount(): void
    {
        $this->passengers = Passenger::whereStatus(RouteStatus::PENDING)->get();
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Pending Routes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-full flex flex-col justify-between bg-white mx-auto shadow-xl mt-1 p-[72px]">
            <div>
                <div class="mt-2">
                    <table class="w-full">
                        <thead class="h-12 border-y-4 border-gray-500">
                        <th>#</th>
                        <th>Passenger</th>
                        <th>Souce</th>
                        <th>Destination</th>
                        <th></th>
                        <th>Driver Name</th>
                        </thead>
                        <tbody>
                        @if($passengers->count() >0)
                            @php $sno = 1 @endphp
                            @foreach($passengers as $passenger)
                                <tr class="text-gray-700 text-center">
                                    <td class="py-2">{{ $sno++ }}</td>
                                    <td>{{ $passenger->user->name }}</td>
                                    @php $placeName = Places::whereId($passenger->destination)->first()->name; @endphp
                                    <td>{{ "N/A" }}</td>
                                    <td>{{ $placeName }}</td>
                                    <td></td>
                                    <td>{{ $passenger->driver->user->name }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="text-gray-700 text-left">
                                <td class="py-2" colspan="5">No routes found</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
