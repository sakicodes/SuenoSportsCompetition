<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Team Management') }}
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
                        {{ __('Create New Team') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Add a new team to the database so they can be assigned to competitions.') }}
                    </p>
                </header>

                <form method="POST" action="{{ route('admin.teams.store') }}" class="mt-6 space-y-6 max-w-xl">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Team Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="short_name" :value="__('Short Name (e.g., BRA, ARG)')" />
                        <x-text-input id="short_name" name="short_name" type="text" class="mt-1 block w-full" :value="old('short_name')" required maxlength="10" />
                        <x-input-error class="mt-2" :messages="$errors->get('short_name')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save Team') }}</x-primary-button>
                    </div>
                </form>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <header class="mb-4">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Existing Teams') }}
                    </h2>
                </header>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Short Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($teams as $team)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $team->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $team->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $team->short_name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($team->active)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        No teams found in the database.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
