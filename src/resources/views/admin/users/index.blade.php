<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Management') }}
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
                        {{ __('Create Player Account') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Generate an account and password for a friend.') }}
                    </p>
                </header>

                <form method="POST" action="{{ route('admin.users.store') }}" class="mt-6 space-y-6 max-w-xl">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Display Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="username" :value="__('Login Username')" />
                        <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username')" required autocomplete="username" />
                        <x-input-error class="mt-2" :messages="$errors->get('username')" />
                    </div>

                    <div>
                        <x-input-label for="password" :value="__('Temporary Password')" />
                        <x-text-input id="password" name="password" type="text" class="mt-1 block w-full" required />
                        <x-input-error class="mt-2" :messages="$errors->get('password')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Create Player') }}</x-primary-button>
                    </div>
                </form>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <header class="mb-4 flex justify-between items-center">
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Active Players') }}
                    </h2>
                </header>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Username</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Points</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($users as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->username }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-indigo-600">{{ $user->current_points }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
					    <form action="{{ route('admin.users.points', $user) }}" method="POST" class="flex items-center gap-2">
						@csrf
						<input type="hidden" name="description" value="Initial Account Funding">
						
						<div class="relative">
						    <input type="number" name="amount" placeholder="Amount" class="block w-24 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-xs px-2 py-1" required>
						</div>
						
						<button type="submit" class="bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-bold py-1 px-3 rounded text-xs transition">
						    Add Pts
						</button>
					    </form>
					</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-sm text-gray-500 text-center">No players created yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
