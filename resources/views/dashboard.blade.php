<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if(auth()->user()->isAdmin())
            <!-- start::Stats -->
            admin
            <!-- end::Stats -->
        @endif

        @if(auth()->user()->isManager())
            <!-- start::Stats -->
            <livewire:dashboard.manager-panel />
            <!-- end::Stats -->
        @endif

        @if(auth()->user()->isDriver())
            <livewire:dashboard.passenger-list />
        @endif

        @if(auth()->user()->isPassenger())
            <!-- start::Map -->
            <livewire:dashboard.passenger-map />
            <!-- end::Map -->
        @endif


    </div>
</x-app-layout>