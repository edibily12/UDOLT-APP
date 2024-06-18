<?php

use App\Enums\RouteStatus;
use App\Models\Passenger;
use App\Models\Payment;
use Livewire\Volt\Component;

new class extends Component {
    public $aborbet, $successfull, $pending;

    public function mount()
    {
        $this->getCountStats();
    }

    public function getCountStats(): void
    {
        $this->aborbet = Passenger::whereStatus(RouteStatus::ABORTED)->count();
        $this->pending = Passenger::whereStatus(RouteStatus::PENDING)->count();
        $this->successfull = Payment::count();
    }
}; ?>

<div>
    <div class="grid grid-cols-1 mb-16 md:grid-cols-2 xl:grid-cols-4 gap-10">
        <div class="px-6 py-6 bg-white rounded-lg shadow-xl">
            <div class="flex items-center justify-between">
                <span class="font-bold text-red-600 text-sm">Aborted Routes</span>
            </div>
            <div class="flex items-center justify-between mt-6">
                <div class="flex flex-col">
                    <div class="flex items-end">
                        <span class="text-2xl 2xl:text-4xl text-red-600 font-bold">{{ $aborbet }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-6 py-6 bg-white rounded-lg shadow-xl">
            <div class="flex items-center justify-between">
                <span class="font-bold text-sm text-green-600">Succeeded Routes</span>
            </div>
            <div class="flex items-center justify-between mt-6">
                <div class="flex flex-col">
                    <div class="flex items-end">
                        <span class="text-2xl text-green-600 2xl:text-4xl font-bold">{{ $successfull }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-6 py-6 bg-white rounded-lg shadow-xl">
            <div class="flex items-center justify-between">
                <span class="font-bold text-sm text-blue-600">Pending Routes</span>
            </div>
            <div class="flex items-center justify-between mt-6">
                <div class="flex flex-col">
                    <div class="flex items-end">
                        <span class="text-2xl 2xl:text-4xl text-blue-600 font-bold">{{ $pending }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-6 py-6 bg-white rounded-lg shadow-xl">
            <div class="flex items-center justify-between">
                <span class="font-bold text-sm text-yellow-600">Total Routes</span>
            </div>
            <div class="flex items-center justify-between mt-6">
                <div class="flex flex-col">
                    <div class="flex items-end">
                        @php $total = $aborbet+$successfull+$pending @endphp
                        <span class="text-2xl 2xl:text-4xl font-bold text-yellow-600">{{ $total }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
