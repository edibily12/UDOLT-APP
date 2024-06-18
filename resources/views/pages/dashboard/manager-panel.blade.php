<?php

use App\Helpers\Helper;
use App\Models\Payment;
use Livewire\Volt\Component;

new class extends Component {
    public $driver_id, $drivers;

    public function mount(): void
    {
        auth()->user()->isManager() ? '' : abort(403, 'Not Authorized to Access This Page');
        $this->drivers = \App\Models\Driver::with(['user'])->get();
    }

    public function with(): array
    {
        return [
            'todayRoutes' => Helper::todayRoutes($this->driver_id),
            'summary' => Payment::getSummary($this->driver_id)
        ];
    }
}; ?>

<div>
    <div class="w-full flex flex-col justify-between bg-white mx-auto shadow-xl mt-1 p-[72px]">
        <div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl tracking-wide">
                    <form>
                        <label>Filter By:</label>
                        <select wire:model.live="driver_id" class="text-sm py-2 w-52 ml-1">
                            <option value="">Select Driver</option>
                            @foreach($drivers as $driver)
                                <option value="{{ $driver->id }}">{{ $driver->user->name }}</option>
                            @endforeach
                        </select>
                    </form>
                    </p>
                </div>
            </div>
            <div class="mt-2">
                <table class="w-full">
                    <thead class="h-12 border-y-4 border-gray-500">
                    <th>#</th>
                    <th>Passenger</th>
                    <th>Source</th>
                    <th>Destination</th>
                    <th></th>
                    <th>Amount</th>
                    </thead>
                    <tbody>
                    @if($todayRoutes->count() >0)
                        @php $sno = 1 @endphp
                        @foreach($todayRoutes as $todayRoute)
                            <tr class="text-gray-700 text-center">
                                <td class="py-2">{{ $sno++ }}</td>
                                <td>{{ $todayRoute->user->name }}</td>
                                <td>{{ "N/A" }}</td>
                                <td>{{ $todayRoute->destination }}</td>
                                <td></td>
                                <td>{{ Number::currency($todayRoute->amount, 'Tsh') }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-gray-700 text-left">
                            <td class="py-2" colspan="5">No routes found</td>
                        </tr>
                    @endif

                    <tr class="border-t-2">
                        <td class="py-2" colspan="5"></td>
                    </tr>
                    <tr class="text-center">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="font-bold">Today</td>
                        <td>{{ Number::currency($summary['amount_today'] ?? 0, 'Tsh') }}</td>
                    </tr>
                    <tr class="text-center">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="font-bold">This Week</td>
                        <td>{{ Number::currency($summary['amount_this_week'] ?? 0, 'Tsh') ?? 'N/A' }}</td>
                    </tr>
                    <tr class="text-center">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="font-bold">This Month</td>
                        <td>{{ Number::currency($summary['amount_this_month'] ?? 0, 'Tsh') }}</td>
                    </tr>
                    <tr class="text-center">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="font-bold">This Year</td>
                        <td>{{ Number::currency($summary['amount_this_year'] ?? 0, 'Tsh') }}</td>
                    </tr>
                    <tr class="text-center">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-lg font-bold py-2">Grand Total</td>
                        <td class="text-lg font-bold text-green-600 py-2">
                            {{ Number::currency($summary['total_amount'] ?? 0, 'Tsh') }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
