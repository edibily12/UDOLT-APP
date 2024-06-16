<?php

use Livewire\Volt\Component;
use \Livewire\Attributes\Rule;

new class extends Component {

    #[Rule('required')]
    public string $name;
    #[Rule('required|min:10|max:10')]
    public int $phone;
    #[Rule('required|email')]
    public string $email;
    #[Rule('required')]
    public string $message;


    public function sendMessage(): void
    {
        $this->validate();

        \App\Models\Message::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'message' => $this->message
        ]);
        
        $this->dispatch('sent-message');
        $this->reset();
            

    }

}; ?>

<div>
    <form wire:submit="sendMessage">
        <div class="space-y-4 mt-8">
            <input type="text" placeholder="Full Name"
                   class="px-2 py-3 bg-white w-full text-sm border-b  outline-none" wire:model.live="name" />
            <x-input-error for="name"/>
            <input type="number" placeholder="Eg 0764175337"
                   class="px-2 py-3 bg-white text-gray-dark w-full text-sm border-b  outline-none" wire:model.live="phone" />
            <x-input-error for="phone"/>
            <input type="email" placeholder="Email"
                   class="px-2 py-3 bg-white text-gray-dark w-full text-sm border-b  outline-none" wire:model.live="email" />
            <x-input-error for="email"/>
            <textarea placeholder="Write Message"
                      class="px-2 pt-3 bg-white text-gray-dark w-full text-sm border-b  outline-none" wire:model.live="message"></textarea>
            <x-input-error for="message"/>
        </div>
        <button type="submit"
                class="mt-8 flex items-center justify-center text-sm w-full rounded px-4 py-2.5 font-semibold bg-primary text-white hover:bg-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" fill='#fff' class="mr-2"
                 viewBox="0 0 548.244 548.244">
                <path fill-rule="evenodd"
                      d="M392.19 156.054 211.268 281.667 22.032 218.58C8.823 214.168-.076 201.775 0 187.852c.077-13.923 9.078-26.24 22.338-30.498L506.15 1.549c11.5-3.697 24.123-.663 32.666 7.88 8.542 8.543 11.577 21.165 7.879 32.666L390.89 525.906c-4.258 13.26-16.575 22.261-30.498 22.338-13.923.076-26.316-8.823-30.728-22.032l-63.393-190.153z"
                      clip-rule="evenodd" data-original="#000000" />
            </svg>
            Send Message
        </button>
    </form>
</div>

@push('scripts')
    <script>
        Livewire.on('sent-message', function () {
            swal('Good job', "Thank you for reaching out! Your message is important to us, and we're here to assist you.", 'success')
        })
    </script>
@endpush
