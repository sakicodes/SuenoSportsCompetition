<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Competition Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Create New Competition') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Set up a new tournament with default scoring rules.') }}
                    </p>
                </header>

                <form method="POST" action="{{ route('admin.competitions.store') }}" class="mt-6 space-y-6 max-w-xl">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Competition Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="description" :value="__('Description (Optional)')" />
                        <textarea id="description" name="description" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" rows="3">{{ old('description') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('description')" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="default_prediction_cost" :value="__('Default Cost')" />
                            <x-text-input id="default_prediction_cost" name="default_prediction_cost" type="number" class="mt-1 block w-full" value="1" required min="0" />
                            <x-input-error class="mt-2" :messages="$errors->get('default_prediction_cost')" />
                        </div>
                        <div>
                            <x-input-label for="default_prediction_multiplier" :value="__('Default Multiplier')" />
                            <x-text-input id="default_prediction_multiplier" name="default_prediction_multiplier" type="number" class="mt-1 block w-full" value="2" required min="1" />
                            <x-input-error class="mt-2" :messages="$errors->get('default_prediction_multiplier')" />
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save Competition') }}</x-primary-button>
                    </div>
                </form>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <header class="mb-4">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Existing Competitions') }}
                    </h2>
                </header>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cost / Multiplier</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($competitions as $competition)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $competition->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ $competition->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $competition->default_prediction_cost }} pts / {{ $competition->default_prediction_multiplier }}x
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-indigo-600 hover:text-indigo-900">
                                        <a href="{{ route('admin.competitions.show', $competition) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">Manage</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-sm text-gray-500 text-center">No competitions found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
