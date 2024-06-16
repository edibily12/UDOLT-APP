<?php

use Livewire\Volt\Component;

new class extends Component {
    use \App\Traits\WithModal;

    public int $formId;
    #[\Livewire\Attributes\Rule('required')]
    public $name, $type, $driver, $vehicle_no;

    public $drivers = [];

    public function mount(): void
    {
        $this->formId = random_int(1, 100);
        $this->drivers = \App\Models\Driver::with(['user'])
            ->whereDoesntHave('vehicle')
            ->get();

    }

    public function save(): void
    {

        $this->validate();
        $vehicle = \App\Models\Vehicle::create([
            'driver_id' => $this->driver,
            'name' => $this->name,
            'type' => $this->type,
            'vehicle_no' => $this->vehicle_no
        ]);

        $this->dispatch('vehicle-created', ['type' => $vehicle->type, 'vehicle_no' => $vehicle->vehicle_no]);
        $this->dispatch('saved');
        $this->reset();
        $this->mount();
    }
}; ?>

<div>
    <x-buttons.success wire:click="openDialogModal">
        <x-icon name="plus" class="mr-2"/>
        {{__('ADD VEHICLE')}}
    </x-buttons.success>

    @php
        $disabled = $errors->any()  ? true : false;
    @endphp

    {{--     modal  --}}
    <x-dialog-modal maxWidth="5xl" wire:model="openModal">
        <x-slot name="title">
            {{ __('ADD NEW VEHICLE') }}
        </x-slot>
        <x-slot name="content">
            <form wire:submit="save" id="add-{{ $this->formId }}">
                <div class="grid grid-cols-1 gap-4">
                    <div class="flex flex-col my-4">
                        <x-label for="password" value="{{ __('Vehicle Name') }}"/>
                        <x-input
                                class="py-2"
                                type="text"
                                placeholder="Name..."
                                wire:model.live="name"
                        />
                        <x-input-error for="name"/>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col my-4">
                        <x-label for="password" value="{{ __('Vehicle Type') }}"/>
                        <select class="block mt-1 w-full capitalize border-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm py-2"
                                wire:model.live="type">
                            <option value="">--Select Option--</option>
                            @foreach(\App\Enums\VehicleType::cases() as $type)
                                <option value="{{ $type->value }}">{{ $type->value }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="type"/>
                    </div>

                    <div class="flex flex-col my-4">
                        <x-label for="password" value="{{ __('Vehicle Driver') }}"/>
                        <select class="block mt-1 w-full capitalize border-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm py-2"
                                wire:model.live="driver">
                            <option value="">--Select Option--</option>
                            @foreach($drivers as $driver)
                                <option value="{{ $driver->id }}">{{ $driver->user->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="driver"/>
                    </div>

                </div>

                <div class="grid grid-cols-1 gap-4">
                    <div class="flex flex-col my-4">
                        <x-label for="password" value="{{ __('Vehicle Number') }}"/>
                        <x-input
                                class="py-2"
                                type="text"
                                placeholder="Number..."
                                wire:model.live="vehicle_no"
                        />
                        <x-input-error for="vehicle_no"/>
                    </div>
                </div>
            </form>
        </x-slot>
        <x-slot name="footer">
            <div class="flex gap-2">
                <x-buttons.secondary wire:click="$toggle('openModal')">
                    <x-icon name="x-mark" class="mr-1"/>
                    {{ __('CANCEL') }}
                </x-buttons.secondary>

                <x-buttons.success wire:target="save" wire:loading.attr="disabled" :disabled="$disabled"
                                   form="add-{{ $this->formId }}">
                    <x-icon name="check-circle" class="mr-1"/>
                    {{ __('SAVE') }}
                </x-buttons.success>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>

@push('scripts')
    <script>
        Livewire.on('vehicle-created', function (user) {
            swal({
                title: "Successfully",
                text: "Vehicle created successfully.\nType: " + user[0].type + " \nVehicle No: " + user[0].vehicle_no,
                icon: "success",
                button: "OK"
            });
        })
    </script>
@endpush
