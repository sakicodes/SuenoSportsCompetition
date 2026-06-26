<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $competition->name }} - {{ __('Dashboard') }}
            </h2>
            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                {{ $competition->status }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tournament Details</h3>
                <p class="text-gray-600">{{ $competition->description ?? 'No description provided.' }}</p>
                <div class="mt-4 grid grid-cols-2 gap-4 text-sm text-gray-500">
                    <div><strong>Default Cost:</strong> {{ $competition->default_prediction_cost }} points</div>
                    <div><strong>Default Multiplier:</strong> {{ $competition->default_prediction_multiplier }}x</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white shadow sm:rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Rounds</h3>
                        <x-primary-button>Add Round</x-primary-button>
                    </div>
                    <p class="text-sm text-gray-500">No rounds created yet.</p>
                </div>

                <div class="bg-white shadow sm:rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Matches</h3>
                        <x-primary-button>Add Match</x-primary-button>
                    </div>
                    <p class="text-sm text-gray-500">No matches created yet.</p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
