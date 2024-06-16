<?php

use App\Helpers\Helper;
use App\Models\Payment;
use Livewire\Volt\Component;

new class extends Component {
    public $todayRoutes, $summary;

    public function mount(): void
    {
        $driverId = auth()->user()->driver->id;
        $this->todayRoutes = Helper::todayRoutes($driverId);

        $this->summary = Payment::getSummary($driverId);
    }

}; ?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Statistics') }}
        </h2>
    </x-slot>
    <!-- start::Activities -->
    <div class="flex flex-col xl:flex-row my-16 space-y-4 xl:space-y-0 xl:space-x-4">
        <!-- start::Schedule -->
        <div class="w-full xl:w-2/3 bg-white shadow-xl rounded-lg space-y-1">
            <h4 class="text-xl font-semibold m-6 capitalize">Today's Routes</h4>
            @if($todayRoutes->count() >0)
                @foreach($todayRoutes as $todayRoute)
                    <!-- start::Task -->
                    <div class="flex">
                        <div class="w-32 flex flex-col items-center justify-center px-2 bg-blue-500 text-gray-100">
                            <span class="text-lg font-black lg:text-lg text-gray-200">
                                {{ $todayRoute->created_at->format('h:i A') }}
                            </span>
                        </div>
                        <div class="w-full flex justify-between p-4 bg-gray-100 hover:bg-gray-200 transition duration-200">
                            <div class="flex flex-col justify-center">
                                <span class="xl:text-lg">Passenger: {{ $todayRoute->user->name }}</span>
                                <span class="flex items-start">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path
                                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path
                                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            <span class="text-xs lg:text-sm">
                                                Destination: <strong>{{ $todayRoute->destination }}</strong>
                                            </span>
                                        </span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-xs font-black lg:text-sm bg-gray-300 p-2 rounded-lg text-center">
                                    {{ "Tsh ".number_format($todayRoute->amount)."/=" }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- end::Task -->
                @endforeach
            @else
                <p class="italic ml-6">No route(s) for today.</p>
            @endif

        </div>
        <!-- end::Schedule -->

        <!-- start::Activity -->
        <div class="w-full xl:w-1/3 bg-white rounded-lg shadow-xl px-4 overflow-y-hidden">
            <h4 class="text-xl font-semibold p-6 capitalize">Summary</h4>
            <div class="grid grid-cols-2 gap-4 h-40 mb-2">
                <div class="bg-green-300 bg-opacity-20 text-green-700 flex flex-col items-center justify-center rounded-lg">
                    <span class="text-4xl font-bold">
                        {{ Number::abbreviate($summary['total_amount'] ?? 0) }}
                    </span>
                    <span>Total Amount(Tsh)</span>
                </div>
                <div class="bg-indigo-300 bg-opacity-20 text-indigo-700 flex flex-col items-center justify-center rounded-lg">
                    <span class="text-4xl font-bold">
                        {{ Number::abbreviate($summary['amount_today'] ?? 0) }}
                    </span>
                    <span>Today(Tsh)</span>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-2 h-32">
                <div class="bg-yellow-300 bg-opacity-20 text-yellow-700 flex flex-col items-center justify-center rounded-lg">
                    <span class="text-3xl font-bold">
                        {{ Number::abbreviate($summary['amount_this_week'] ?? 0) }}
                    </span>
                    <span>This Week(Tsh)</span>
                </div>
                <div class="bg-blue-300 bg-opacity-20 text-blue-700 flex flex-col items-center justify-center rounded-lg">
                    <span class="text-3xl font-bold">
                        {{ Number::abbreviate($summary['amount_this_month'] ?? 0) }}
                    </span>
                    <span>This Month(Tsh)</span>
                </div>
                <div class="bg-red-300 bg-opacity-20 text-red-700 flex flex-col items-center justify-center rounded-lg">
                    <span class="text-3xl font-bold">
                        {{ Number::abbreviate($summary['amount_this_year'] ?? 0) }}
                    </span>
                    <span>This Year(Tsh)</span>
                </div>
            </div>
        </div>
        <!-- end::Activity -->
    </div>
    <!-- end::Activities -->
</div>
