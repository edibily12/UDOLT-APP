<?php

use App\Traits\WithFilter;
use Livewire\Volt\Component;

new class extends Component {
    use \Livewire\WithPagination;
    use WithFilter;

    protected $listeners = ['saved' => '$refresh'];

    public function mount(): void
    {
        auth()->user()->isManager() ? '' : abort(403, 'Not Authorized to Access This Page');
    }


    public function with(): array
    {
        return [
            'vehicles' => \App\Models\Vehicle::search($this->search)
                ->with(['driver'])
                ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
                ->paginate($this->perPage),
        ];
    }

    public function deleteVehicle(\App\Models\Vehicle $vehicle): void
    {
        $vehicle->deleteOrFail();

        $this->dispatch('vehicle-deleted');
        $this->dispatch('saved');
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('All Vehicles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <!-- start::Advance Table Filters -->
        <div x-data="{ filter: false }" class="bg-white rounded-lg px-8 py-6 overflow-x-scroll custom-scrollbar">

            {{-- add vehicle --}}
            <livewire:vehicles.create/>

            <div class="mt-8 mb-3 flex flex-col md:flex-row items-start md:items-center md:justify-between">
                <div class="flex items-center justify-center space-x-4">
                    <input
                            type="search"
                            wire:model.live="search"
                            placeholder="Search..."
                            class="w-48 lg:w-72 bg-gray-200 text-sm py-2 pl-4 rounded-lg focus:ring-0 focus:outline-none"
                    >
                </div>
                <div class="mt-4 md:mt-0">
                    <form>
                        <label>Order By:</label>
                        <select wire:model.live="orderBy" class="text-sm py-0.5 ml-1">
                            <option value="created_at">Date</option>
                            <option value="name">Name</option>
                            <option value="type">Type</option>
                        </select>

                        <select wire:model.live="orderAsc" class="text-sm py-0.5 ml-1">
                            <option value="1">Asc</option>
                            <option value="0">Desc</option>
                        </select>

                        <select wire:model.live="perPage" class="text-sm py-0.5 ml-1">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </form>
                </div>
            </div>

            <table class="w-full whitespace-nowrap mb-8">
                <thead class="bg-secondary text-gray-100 font-bold">
                <td class="py-2 pl-2">
                    #
                </td>
                <td class="py-2 pl-2">
                    Vehicle Name
                </td>
                <td class="py-2 pl-2">
                    Vehicle Type
                </td>
                <td class="py-2 pl-2">
                    Vehicle No
                </td>
                <td class="py-2 pl-2">
                    Vehicle Driver
                </td>
                <td class="py-2 pl-2"></td>
                </thead>
                <tbody class="text-sm">
                @if($vehicles->count() > 0)
                    @php $sno = 1 @endphp
                    @foreach($vehicles as $vehicle)
                        <tr class="bg-gray-100 hover:bg-primary hover:bg-opacity-20 transition duration-200">
                            <td class="py-3 pl-2">
                                {{ $sno++ }}
                            </td>
                            <td class="py-3 pl-2 capitalize">
                                {{ $vehicle->name }}
                            </td>
                            <td class="py-3 pl-2">
                                {{ $vehicle->type }}
                            </td>
                            <td class="py-3 pl-2">
                                {{ $vehicle->vehicle_no }}
                            </td>

                            <td class="py-3 pl-2">
                                {{ $vehicle->driver->user->name ?? 'N/A' }}
                            </td>

                            <td class="py-3 pl-2 flex items-center space-x-2">
                                <livewire:vehicles.edit :$vehicle :key="'edit-vehicle'.now().$vehicle->id" />

                                <a title="Delete vehicle" href="#" wire:click="deleteVehicle({{$vehicle->id}})"
                                   wire:confirm.prompt="Are you sure? type YES|YES">
                                    <x-icon name="trash" class="text-xl text-red-600 font-black"/>
                                </a>
                            </td>

                        </tr>
                    @endforeach
                @else
                    <tr class="bg-gray-100 hover:bg-gray-700 hover:bg-opacity-20 transition duration-200">
                        <td class="py-3 pl-2" colspan="6">
                            <p>No Vehicle(s) found</p>
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
            {{ $vehicles->links(data: ['scrollTo' => false]) }}
        </div>
        <!-- end::Advance Table Filters -->
    </div>
</div>

@push('scripts')
    <script>
        Livewire.on('vehicle-deleted', function (type) {
            swal({
                title: "Successfully",
                text: "Vehicle deleted successfully.",
                icon: "success",
                button: "OK",
                timer: 3000,
            });
        })

    </script>
@endpush
