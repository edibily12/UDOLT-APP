<?php

use Livewire\Volt\Component;

new class extends Component {
    use \App\Traits\WithModal;

    #[\Livewire\Attributes\Rule('required|min:3|max:100')]
    public $name, $type, $vehicle_no;
    public $vehicle, $formId;

    public function mount(\App\Models\Vehicle $vehicle): void
    {
        $this->vehicle = $vehicle;
        $this->formId = random_int(1, 100);

        $this->fill(
            $this->vehicle->only(
                'name', 'type', 'vehicle_no'
            )
        );
    }

    public function save(): void
    {
        $this->validate();
        $this->vehicle->update([
            'name' => \Illuminate\Support\Str::title($this->name),
            'type' => \Illuminate\Support\Str::lower($this->type),
            'vehicle_no' => $this->vehicle_no,
        ]);

        $this->dispatch('vehicle-updated', $this->type);
        $this->dispatch('saved');
        $this->reset();

    }
}; ?>

<div>
    @php
        $disabled = $errors->any()  ? true : false;
    @endphp

    <a title="edit vehicle" href="#" wire:click="openDialogModal">
        <x-icon name="pencil-square" class="text-xl text-yellow-600 font-black"/>
    </a>

    {{--     modal  --}}
    <x-dialog-modal maxWidth="3xl" wire:model="openModal">
        <x-slot name="title">
            {{ __('EDIT VEHICLE') }}
        </x-slot>
        <x-slot name="content">
            <form wire:submit="save" id="edit-{{ $this->formId }}">
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
                                   form="edit-{{ $this->formId }}">
                    <x-icon name="check-circle" class="mr-1"/>
                    {{ __('SAVE') }}
                </x-buttons.success>
            </div>
        </x-slot>
    </x-dialog-modal>
</div>

@push('scripts')
    <script>
        Livewire.on('vehicle-updated', function (type) {
            swal({
                title: "Successfully",
                text: "Vehicle updated successfully.\nType: " + type,
                icon: "success",
                button: "OK"
            });
        })
    </script>
@endpush
