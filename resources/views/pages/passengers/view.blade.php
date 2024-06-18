<?php

use App\Enums\RouteStatus;
use App\Events\ConfirmRoute;
use App\Jobs\DeletePassenger;
use App\Models\Payment;
use Livewire\Volt\Component;
use \App\Models\Passenger;
use \App\Helpers\Helper;

new class extends Component {
    public $passenger;
    public $distance, $transportFee;
    public $latFrom, $longFrom, $latTo, $longTo, $placeTo;

    public function mount($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $this->passenger = Passenger::with(['user', 'driver'])->findOrFail($id);
            $this->latFrom = $this->passenger->user->latitude;
            $this->longFrom = $this->passenger->user->longitude;

            $this->placeTo = \App\Models\Places::findOrFail($this->passenger->destination);
            $this->latTo = $this->placeTo->latitude;
            $this->longTo = $this->placeTo->longitude;

            $this->distance = Helper::haversineGreatCircleDistance(
                $this->latFrom, $this->longFrom, $this->latTo, $this->longTo
            );
        } catch (Exception $e) {
            return redirect()->route('dashboard');
        }
    }

    public function confirmPayment($data)
    {
        //decode the JSON string into an associative array
        $parameters = json_decode($data, true, 512, JSON_THROW_ON_ERROR);

        //extract parameters
        $passengerId = $parameters['passengerId'];
        $userId = $parameters['userId'];
        $driverId = $parameters['driverId'];
        $distance = $parameters['distance'];
        $amount = $parameters['amount'];
        $destination = $parameters['destination'];

        $passenger = Passenger::findOrFail($passengerId);

        $payment = Payment::create([
            'user_id' => $userId,
            'driver_id' => $driverId,
            'distance' => $distance,
            'amount' => $amount,
            'destination' => $destination
        ]);

        DeletePassenger::dispatch($this->passenger)->delay(now()->addSeconds(5));
        $this->dispatch('payment-done');
        return redirect()->route('dashboard');

    }

    public function confirmOrCancelRoute(Passenger $passenger): void
    {
        $passenger->confirmed = !$passenger->confirmed;
        $passenger->save();
        if ($passenger->confirmed) {
            $this->dispatch('confirm-route');
        }

        if (!$passenger->confirmed) {
            $this->dispatch('cancel-route');
        }
        $this->mount(encrypt($passenger->id));

        ConfirmRoute::dispatch();
    }

    public function deletePassenger($id)
    {
        $passenger = Passenger::findOrFail($id);
        $passenger->forceDelete();
        return redirect()->route('dashboard');
    }


}; ?>

<div>
    <!-- start::Inbox -->
    <div class="w-full bg-white shadow-xl rounded-lg flex overflow-x-auto custom-scrollbar">
        <div class="w-64 px-4">
            @if($passenger->status === RouteStatus::PENDING)
                @if(!$passenger->confirmed)
                    <div class="h-16 flex items-center">
                        <x-buttons.primary wire:click="confirmOrCancelRoute({{ $passenger->id }})"
                                           class="w-48 mx-auto bg-primary hover:bg-primary-dark flex items-center justify-center text-gray-100 py-2 rounded space-x-2 transition duration-150">
                            <x-icon name="check" class="mr-1"/> {{__('CONFIRM')}}
                        </x-buttons.primary>
                    </div>
                @else
                    <div class="h-16 flex items-center">
                        <x-buttons.danger wire:click="confirmOrCancelRoute({{ $passenger->id }})"
                                          class="w-48 mx-auto bg-primary hover:bg-primary-dark flex items-center justify-center text-gray-100 py-2 rounded space-x-2 transition duration-150">
                            <x-icon name="check" class="mr-1"/> {{__('CANCEL')}}
                        </x-buttons.danger>
                    </div>
                @endif
            @endif
            <div class="px-2 pt-4 pb-8 border-r border-gray-300">
                <ul class="space-y-2">
                    <li>
                        <h4 class="flex text-lg text-gray-800 font-bold pb-2 mb-4">
                            <x-icon name="home-modern" class="mr-2"/>
                            Destination: <span class="font-black ml-1">{{ $placeTo->name }}</span>
                        </h4>
                    </li>
                    <li>
                        <h4 class="flex text-lg text-gray-800 font-bold pb-2 mb-4">
                            <x-icon name="arrow-uturn-up" class="mr-2"/>
                            <span class="font-black">Distance: {{ round($distance)."KM" }} </span>
                        </h4>
                    </li>
                    <li>
                        <h4 class="flex text-lg text-gray-800 font-bold pb-2 mb-4 border-b-2">
                            <x-icon name="currency-dollar" class="mr-2"/>
                            @php $amount = round($distance) * 1000 @endphp
                            <span class="font-black">Fee: {{ "Tsh ".number_format( $amount) }} </span>
                        </h4>
                    </li>
                    @if($passenger->status === RouteStatus::PENDING)
                        @php
                            $parameters = json_encode([
                                'passengerId' => $passenger->id,
                                'userId' => $passenger->user_id,
                                'driverId' => $passenger->driver_id,
                                'distance' => $distance,
                                'amount' => $amount,
                                'destination' => $placeTo->name
                            ], JSON_THROW_ON_ERROR)
                        @endphp
                        @if($passenger->confirmed)
                            <li>
                                <x-buttons.success wire:click="confirmPayment('{{ $parameters }}')">
                                    <x-icon name="check-circle" class="mr-1"/>
                                    {{__('DONE')}}
                                </x-buttons.success>
                            </li>
                        @endif
                    @endif
                </ul>
            </div>
        </div>

        <div class="flex-1 px-2">
            <div class="h-16 flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" wire:navigate
                       class="flex items-center text-gray-700 px-2 py-1 space-x-0.5 border border-gray-300 rounded-lg shadow hover:bg-gray-200 transition duration-100"
                       title="Back">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-bold">Back</span>
                    </a>
                    <h1 class="flex items-center text-gray-700 px-2 py-1 space-x-0.5 " title="Passenger name">
                        <x-icon name="user"/>
                        <span class="text-sm font-bold">{{ $passenger->user->name }}</span>
                    </h1>
                </div>
            </div>
            @if($passenger->status === RouteStatus::PENDING)
                <div class="mb-6">
                    {{--         passenger map --}}
                    <h4 class="text-lg text-gray-800 font-bold pb-2 mb-4 border-b-2">
                        <span class="font-black">Passenger Location</span>
                    </h4>
                    <div class="h-[600px]">
                        <iframe
                                src="https://www.google.com/maps/embed/v1/place?key=AIzaSyD94Nn1uj4OJxhpy7UPW6vFp-xAPj9TqR0&q={{ $latFrom }},{{ $longFrom }}&zoom=15"
                                class="left-0 top-0 h-full w-full rounded-t-lg lg:rounded-tr-none lg:rounded-bl-lg"
                                frameborder="0"
                                allowfullscreen>
                        </iframe>
                    </div>

                </div>
            @elseif($passenger->status === RouteStatus::ABORTED)
                <h4 class="text-lg text-red-600 font-bold pb-2 mb-4 border-b-2">
                    <span class="font-black">Route Canceled by passenger</span>
                </h4>
                <x-buttons.danger wire:click="deletePassenger({{ $passenger->id }})">Delete</x-buttons.danger>
            @else
                <h4 class="text-lg text-green-600 font-bold pb-2 mb-4 border-b-2">
                    <span class="font-black">Route completed</span>
                </h4>
            @endif
        </div>
    </div>
    <!-- end::Inbox -->
</div>

@push('scripts')
    <script>
        Livewire.on('payment-done', function () {
            swal('Good Job', 'Payment received successfully', 'success')
        })

        Livewire.on('payment-error', function () {
            swal('Oops!!', 'Something went wrong.', 'error')
        })

        Livewire.on('confirm-route', function () {
            swal('Good Job', 'Route confirmed successfully', 'success')
        })

        Livewire.on('cancel-route', function () {
            swal('Good Job', 'Route canceled successfully', 'success')
        })

        Livewire.on('error', function () {
            swal('Opps', 'Invalid input, please contact admin fore more details.', 'error')
        })
    </script>
@endpush
