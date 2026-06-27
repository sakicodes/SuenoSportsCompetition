<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Open Tournaments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 flex justify-between items-end">
                <h3 class="text-gray-500 text-sm font-bold uppercase tracking-wider">Available to Play</h3>
                <div class="text-sm text-gray-600 bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100">
                    Your Balance: <span class="font-bold text-indigo-700">{{ auth()->user()->current_points }} pts</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($competitions as $competition)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-t-4 border-indigo-500 flex flex-col justify-between">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="text-xl font-bold text-gray-900">{{ $competition->name }}</h4>
                                <span class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Open</span>
                            </div>
                            
                            <p class="text-sm text-gray-600 mb-6 line-clamp-2">
                                {{ $competition->description ?? 'Join this tournament to lock in your predictions.' }}
                            </p>
                            
                            <div class="bg-gray-50 rounded p-4 mb-2 text-xs text-gray-700 border">
                                <div class="flex justify-between mb-2 pb-2 border-b">
                                    <span class="font-medium">Default Entry Cost:</span>
                                    <span class="font-bold text-indigo-600">{{ $competition->default_prediction_cost }} pts</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="font-medium">Reward Multiplier:</span>
                                    <span class="font-bold text-green-600">{{ $competition->default_prediction_multiplier }}x</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="px-6 pb-6 mt-auto">
                            <!-- This route goes to the specific tournament lobby to view matches -->
                            <a href="{{ route('player.competitions.show', $competition) }}" class="block text-center w-full px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                                Enter Tournament
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 bg-white rounded-lg shadow-sm border border-gray-200">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No active tournaments</h3>
                        <p class="mt-1 text-sm text-gray-500">The admin hasn't opened any competitions yet. Check back soon!</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
