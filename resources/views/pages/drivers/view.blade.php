<?php

use Livewire\Volt\Component;

new class extends Component {
    public $user;
    public function mount($id): void
    {
        $id = Crypt::decrypt($id);
        $this->user = \App\Models\User::with('driver')->findOrFail($id);
    }
}; ?>

<div>
    <div class="h-full bg-gray-200">
        <div class="bg-white rounded-lg shadow-xl pb-8">
            <div class="w-full h-[250px]">
                <img src="{{ \Illuminate\Support\Facades\Storage::url('files/images/profile-background.jpg') }}"
                     class="w-full h-full rounded-tl-lg rounded-tr-lg">
            </div>
            <div class="flex flex-col items-center -mt-20">
                <img src="{{ \Illuminate\Support\Facades\Storage::url('files/images/profile.jpg') }}"
                     class="w-40 border-4 border-white rounded-full">
                <div class="flex items-center space-x-2 mt-2">
                    <p class="text-2xl">Amanda Ross</p>
                    <span class="bg-blue-500 rounded-full p-1" title="Verified">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-gray-100 h-2.5 w-2.5"
                                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4"
                                              d="M5 13l4 4L19 7"/>
                                    </svg>
                                </span>
                </div>
                <p class="text-gray-700">{{ $user->name }}</p>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
            </div>
            <div class="flex-1 flex flex-col items-center lg:items-end justify-end px-8 mt-2">
                <div class="flex items-center space-x-4 mt-2">
                    <button wire:click="getTransport"
                            class="flex items-center bg-blue-600 hover:bg-blue-700 text-gray-100 px-4 py-2 rounded text-sm space-x-2 transition duration-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                             fill="currentColor">
                            <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                        </svg>
                        <span>MESSAGE</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="my-4 flex flex-col 2xl:flex-row space-y-4 2xl:space-y-0 2xl:space-x-4">
            <div class="w-full flex flex-col 2xl:w-1/3">
                <div class="flex-1 bg-white rounded-lg shadow-xl p-8">
                    <h4 class="text-xl text-gray-900 font-bold">Personal Info</h4>
                    <ul class="mt-2 text-gray-700">
                        <li class="flex border-y py-2">
                            <span class="font-bold w-32">Full name:</span>
                            <span class="text-gray-700">{{ $user->name }}</span>
                        </li>
                        <li class="flex border-b py-2">
                            <span class="font-bold w-32">Birthday:</span>
                            <span class="text-gray-700">24 Jul, 1991</span>
                        </li>
                        <li class="flex border-b py-2">
                            <span class="font-bold w-32">Joined:</span>
                            <span class="text-gray-700">{{ $user->created_at->format('d-m-Y') }}</span>
                        </li>
                        <li class="flex border-b py-2">
                            <span class="font-bold w-32">Mobile:</span>
                            <span class="text-gray-700">{{ $user->phone ?? '-' }}</span>
                        </li>
                        <li class="flex border-b py-2">
                            <span class="font-bold w-32">Email:</span>
                            <span class="text-gray-700">{{ $user->email }}</span>
                        </li>
                        <li class="flex border-b py-2">
                            <span class="font-bold w-32">License Number:</span>
                            <span class="text-gray-700">{{ $user->driver->license_number ?? '-' }}</span>
                        </li>
                        <li class="flex border-b py-2">
                            <span class="font-bold w-32">Nida Number:</span>
                            <span class="text-gray-700">{{ $user->driver->nida ?? '-' }}</span>
                        </li>
                        <li class="flex border-b py-2">
                            <span class="font-bold w-32">Languages:</span>
                            <span class="text-gray-700">English, Swahili</span>
                        </li>
                        <li class="flex border-b py-2">
                            <span class="font-bold w-32">Vehicle Name:</span>
                            <span class="text-gray-700">{{ $user->driver->vehicle->name ?? '-' }}</span>
                        </li>
                        <li class="flex border-b py-2">
                            <span class="font-bold w-32">Vehicle Type:</span>
                            <span class="text-gray-700">{{ $user->driver->vehicle->type ?? '-' }}</span>
                        </li>
                        <li class="flex border-b py-2">
                            <span class="font-bold w-32">Vehicle Number:</span>
                            <span class="text-gray-700">{{ $user->driver->vehicle->vehicle_no ?? '-' }}</span>
                        </li>

                        <li class="flex items-center border-b py-2 space-x-2">
                            <span class="font-bold w-24">Elsewhere:</span>
                            <a href="#" title="Facebook">
                                <svg class="w-5 h-5" id="Layer_1" data-name="Layer 1"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 506.86 506.86">
                                    <defs>
                                        <style>.cls-1 {
                                                fill: #1877f2;
                                            }

                                            .cls-2 {
                                                fill: #fff;
                                            }</style>
                                    </defs>
                                    <path class="cls-1"
                                          d="M506.86,253.43C506.86,113.46,393.39,0,253.43,0S0,113.46,0,253.43C0,379.92,92.68,484.77,213.83,503.78V326.69H149.48V253.43h64.35V197.6c0-63.52,37.84-98.6,95.72-98.6,27.73,0,56.73,5,56.73,5v62.36H334.33c-31.49,0-41.3,19.54-41.3,39.58v47.54h70.28l-11.23,73.26H293V503.78C414.18,484.77,506.86,379.92,506.86,253.43Z"/>
                                    <path class="cls-2"
                                          d="M352.08,326.69l11.23-73.26H293V205.89c0-20,9.81-39.58,41.3-39.58h31.95V104s-29-5-56.73-5c-57.88,0-95.72,35.08-95.72,98.6v55.83H149.48v73.26h64.35V503.78a256.11,256.11,0,0,0,79.2,0V326.69Z"/>
                                </svg>
                            </a>
                            <a href="#" title="Twitter">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 333333 333333" shape-rendering="geometricPrecision"
                                     text-rendering="geometricPrecision" image-rendering="optimizeQuality"
                                     fill-rule="evenodd" clip-rule="evenodd">
                                    <path d="M166667 0c92048 0 166667 74619 166667 166667s-74619 166667-166667 166667S0 258715 0 166667 74619 0 166667 0zm90493 110539c-6654 2976-13822 4953-21307 5835 7669-4593 13533-11870 16333-20535-7168 4239-15133 7348-23574 9011-6787-7211-16426-11694-27105-11694-20504 0-37104 16610-37104 37101 0 2893 320 5722 949 8450-30852-1564-58204-16333-76513-38806-3285 5666-5022 12109-5022 18661v4c0 12866 6532 24246 16500 30882-6083-180-11804-1876-16828-4626v464c0 17993 12789 33007 29783 36400-3113 845-6400 1313-9786 1313-2398 0-4709-247-7007-665 4746 14736 18448 25478 34673 25791-12722 9967-28700 15902-46120 15902-3006 0-5935-184-8860-534 16466 10565 35972 16684 56928 16684 68271 0 105636-56577 105636-105632 0-1630-36-3209-104-4806 7251-5187 13538-11733 18514-19185l17-17-3 2z"
                                          fill="#1da1f2"/>
                                </svg>
                            </a>
                            <a href="#" title="LinkedIn">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 333333 333333" shape-rendering="geometricPrecision"
                                     text-rendering="geometricPrecision" image-rendering="optimizeQuality"
                                     fill-rule="evenodd" clip-rule="evenodd">
                                    <path d="M166667 0c92048 0 166667 74619 166667 166667s-74619 166667-166667 166667S0 258715 0 166667 74619 0 166667 0zm-18220 138885h28897v14814l418 1c4024-7220 13865-14814 28538-14814 30514-1 36157 18989 36157 43691v50320l-30136 1v-44607c0-10634-221-24322-15670-24322-15691 0-18096 11575-18096 23548v45382h-30109v-94013zm-20892-26114c0 8650-7020 15670-15670 15670s-15672-7020-15672-15670 7022-15670 15672-15670 15670 7020 15670 15670zm-31342 26114h31342v94013H96213v-94013z"
                                          fill="#0077b5"/>
                                </svg>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="flex flex-col w-full 2xl:w-2/3">
                <div class="flex-1 bg-white rounded-lg shadow-xl p-8">
                    <h4 class="text-xl text-gray-900 font-bold">About</h4>
                    <p class="mt-2 text-gray-700">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Nesciunt voluptates obcaecati numquam error et ut fugiat asperiores. Sunt nulla ad
                        incidunt laboriosam, laudantium est unde natus cum numquam, neque facere. Lorem ipsum
                        dolor sit amet consectetur adipisicing elit. Ut, magni odio magnam commodi sunt ipsum
                        eum! Voluptas eveniet aperiam at maxime, iste id dicta autem odio laudantium eligendi
                        commodi distinctio!</p>
                </div>
            </div>
        </div>
    </div>
</div>
