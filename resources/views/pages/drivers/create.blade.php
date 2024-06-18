<?php

use App\Enums\UserType;
use App\Models\Role;
use Livewire\Volt\Component;

new class extends Component {
    use \App\Traits\WithModal;

    public int $formId;
    #[\Livewire\Attributes\Rule('required')]
    public $name, $phone;

    #[\Livewire\Attributes\Rule('required|unique:users,email')]
    public $email;

    public $license_number, $nida;


    public function mount(): void
    {
        $this->formId = random_int(1, 100);
    }

    public function save(): void
    {

        $this->validate();
        $user = \App\Models\User::create([
            'name' => $this->name,
            'email' => $this->email,
            'type' => UserType::DRV->value,
            'phone' => $this->phone,
            'password' => bcrypt('1234')
        ]);

        $user->driver()->create([
            'nida' => $this->nida,
            'license_number' => $this->license_number
        ]);

        $user->roles()->sync(Role::where('name', \App\Enums\RoleName::DRV->value)->first());


        $this->dispatch('driver-created', ['name' => $user->name, 'username' => $user->username]);
        $this->dispatch('saved');
        $this->resetExcept('formId');
    }

}; ?>

<div>
    <x-buttons.primary wire:click="openDialogModal">
        <x-icon name="plus" class="mr-2"/>
        {{__('ADD DRIVER')}}
    </x-buttons.primary>

    @php
        $disabled = $errors->any()  ? true : false;
    @endphp

    {{--     modal  --}}
    <x-dialog-modal maxWidth="5xl" wire:model="openModal">
        <x-slot name="title">
            {{ __('ADD NEW DRIVER') }}
        </x-slot>
        <x-slot name="content">
            <form wire:submit="save" id="add-{{ $this->formId }}">
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col my-4">
                        <x-label for="password" value="{{ __('Full Name') }}"/>
                        <x-input
                                class="py-2"
                                type="text"
                                placeholder="Name..."
                                wire:model.live="name"
                        />
                        <x-input-error for="name"/>
                    </div>

                    <div class="flex flex-col my-4">
                        <x-label for="email" value="{{ __('Email') }}"/>
                        <x-input
                                class="py-2"
                                type="email"
                                placeholder="Email..."
                                wire:model.live="email"
                        />
                        <x-input-error for="email"/>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex flex-col my-4">
                        <x-label for="email" value="{{ __('Nida') }}"/>
                        <x-input
                                class="py-2"
                                type="number"
                                placeholder="nida..."
                                wire:model.live="nida"
                        />
                        <x-input-error for="nida"/>
                    </div>

                    <div class="flex flex-col my-4">
                        <x-label for="password" value="{{ __('Phone Number(optional)') }}"/>
                        <x-input
                                class="py-2"
                                type="number"
                                placeholder="0712345467"
                                wire:model.live="phone"
                        />
                        <x-input-error for="phone"/>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <div class="flex flex-col my-4">
                        <x-label for="password" value="{{ __('License Number') }}"/>
                        <x-input
                                class="py-2"
                                type="text"
                                placeholder=""
                                wire:model.live="license_number"
                        />
                        <x-input-error for="license_number"/>
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
        Livewire.on('driver-created', function (user) {
            swal({
                title: "Successfully",
                text: "Driver created successfully.\nName: " + user[0].name + " \nUsername: " + user[0].username,
                icon: "success",
                button: "OK"
            });
        })
    </script>
@endpush
