<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-black text-2xl text-gray-900 uppercase tracking-tight">
                    {{ $competition->name }}
                </h2>
                <p class="text-sm text-gray-600">{{ $competition->description }}</p>
            </div>
            <div class="bg-indigo-600 text-white px-4 py-2 rounded-lg shadow-sm border border-indigo-700 text-sm font-bold">
                Available Wallet: {{ auth()->user()->current_points }} pts
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
                    <p class="font-bold">Success!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm" role="alert">
                    <p class="font-bold">Prediction Failed</p>
                    <ul class="list-disc ml-5 text-sm mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @forelse($competition->rounds as $round)
                <details class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-200">
                    <summary class="bg-gray-50 border-b border-gray-200 p-4 sm:px-6 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-900 uppercase tracking-wide">{{ $round->name }}</h3>
                        <div class="text-xs font-semibold px-3 py-1 rounded-full {{ $round->locked || now()->isAfter($round->prediction_lock_datetime) ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                            {{ $round->locked || now()->isAfter($round->prediction_lock_datetime) ? 'Locked' : 'Open Until ' . \Carbon\Carbon::parse($round->prediction_lock_datetime)->format('M j, H:i') }}
                        </div>
                    </summary>

                    <div class="p-4 sm:p-6 bg-gray-100 grid grid-cols-1 lg:grid-cols-2 gap-6">
                        @forelse($competition->matches->where('round_id', $round->id) as $match)
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5 flex flex-col justify-between">
                                
                                <div class="text-center mb-4 pb-4 border-b border-gray-100">
                                    <span class="text-xs font-black text-indigo-500 uppercase tracking-widest">Match #{{ $match->id }}</span>
                                    <div class="mt-2 text-xl font-bold text-gray-900 flex justify-center items-center gap-3">
                                        <span>{{ $match->homeTeam->short_name }}</span>
                                        <span class="text-sm text-gray-400 font-normal">vs</span>
                                        <span>{{ $match->awayTeam->short_name }}</span>
                                    </div>
                                    <div class="mt-1 text-xs text-gray-500">
                                        Kickoff: {{ \Carbon\Carbon::parse($match->match_datetime)->format('M j, Y @ H:i') }}
                                    </div>
                                </div>
				@php
                                    $existingPrediction = $userPredictions->get($match->id);
                                @endphp
				@if(!$round->locked && now()->isBefore($round->prediction_lock_datetime) && !in_array($match->status, ['COMPLETED', 'CLOSED', 'CANCELLED']))
                                    <form action="{{ route('player.predictions.store', $match) }}" method="POST" class="space-y-4">
                                        @csrf
                                        
                                        <div>
                                            <x-input-label for="predicted_team_id_{{ $match->id }}" value="Select Winner" class="text-xs uppercase text-gray-500 font-bold" />
                                            <select name="predicted_team_id" id="predicted_team_id_{{ $match->id }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm" required>
                                                <option value="" disabled {{ !$existingPrediction ? 'selected' : '' }}>Who will win?</option>
                                                <option value="{{ $match->home_team_id }}" {{ $existingPrediction && $existingPrediction->predicted_team_id == $match->home_team_id ? 'selected' : '' }}>{{ $match->homeTeam->name }}</option>
                                                <option value="{{ $match->away_team_id }}" {{ $existingPrediction && $existingPrediction->predicted_team_id == $match->away_team_id ? 'selected' : '' }}>{{ $match->awayTeam->name }}</option>
                                            </select>
                                        </div>

                                        <div>
                                            <x-input-label for="points_spent_{{ $match->id }}" value="Points to Wager" class="text-xs uppercase text-gray-500 font-bold" />
                                            <div class="relative mt-1">
                                                @if($existingPrediction)
                                                    <input type="number" value="{{ $existingPrediction->points_spent }}" class="block w-full border-gray-300 bg-gray-100 text-gray-500 rounded-md shadow-sm text-sm pl-3 pr-12 cursor-not-allowed" disabled>
                                                    <input type="hidden" name="points_spent" value="{{ $existingPrediction->points_spent }}">
                                                @else
                                                    <input type="number" name="points_spent" id="points_spent_{{ $match->id }}" min="1" max="{{ auth()->user()->current_points }}" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm pl-3 pr-12" placeholder="e.g., 50" required>
                                                @endif
                                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-xs text-gray-400 font-bold">
                                                    PTS
                                                </div>
                                            </div>
                                            <p class="text-[10px] text-gray-400 mt-1 text-right">Potential Return: Multiplier {{ $round->prediction_multiplier ?? $competition->default_prediction_multiplier }}x</p>
                                        </div>

                                        <button type="submit" class="w-full {{ $existingPrediction ? 'bg-indigo-600 hover:bg-indigo-700' : 'bg-gray-900 hover:bg-black' }} text-white font-bold py-2 px-4 rounded-md text-sm uppercase tracking-wider transition-colors shadow-sm">
                                            {{ $existingPrediction ? 'Update Prediction' : 'Lock In Wager' }}
                                        </button>
                                    </form>
                                @else
                                    <div class="text-center py-4 bg-gray-50 rounded-md border border-gray-200 flex flex-col items-center justify-center h-full">
                                        @if($existingPrediction)
                                            
                                            @if(in_array($match->status, ['COMPLETED', 'CLOSED']))
                                                <div class="mb-3">
                                                    <span class="px-3 py-1 text-[10px] font-black rounded-full uppercase tracking-widest
                                                        {{ $existingPrediction->status === 'CORRECT' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                                        {{ $existingPrediction->status }}
                                                    </span>
                                                </div>
                                                <p class="text-[10px] text-gray-500 uppercase font-bold mb-1">Your Pick</p>
                                                <div class="flex justify-center items-center gap-2 mb-2">
                                                    <span class="font-bold text-gray-800">{{ $existingPrediction->predictedTeam->name }}</span>
                                                    <span class="text-xs bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full">{{ $existingPrediction->points_spent }} PTS</span>
                                                </div>
                                                
                                                @if($existingPrediction->status === 'CORRECT')
                                                    <p class="text-sm font-black text-green-600">+{{ $existingPrediction->points_awarded }} PTS WON!</p>
                                                @else
                                                    <p class="text-sm font-black text-red-500">0 PTS RETURN</p>
                                                @endif

                                            @elseif($match->status === 'CANCELLED')
                                                <span class="px-2 py-1 text-[10px] font-bold rounded-full bg-gray-200 text-gray-800 uppercase tracking-wider mb-2">Cancelled</span>
                                                <p class="text-xs text-gray-500">Wager Refunded</p>
                                            
                                            @else
                                                <p class="text-xs text-gray-500 uppercase font-bold mb-1">Your Locked Wager</p>
                                                <div class="flex justify-center items-center gap-2 mb-2">
                                                    <span class="font-bold text-indigo-700">{{ $existingPrediction->predictedTeam->name }}</span>
                                                    <span class="text-xs bg-indigo-100 text-indigo-800 px-2 py-0.5 rounded-full">{{ $existingPrediction->points_spent }} PTS</span>
                                                </div>
                                                <p class="text-[10px] text-gray-400">Awaiting match results...</p>
                                            @endif

                                        @else
                                            <p class="text-sm font-bold text-gray-500 uppercase mb-1">Match Locked</p>
                                            <p class="text-xs text-gray-400">You did not make a prediction.</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="col-span-full text-center py-6 text-sm text-gray-500">
                                No matches scheduled for this round yet.
                            </div>
                        @endforelse
                    </div>
                </details>
            @empty
                <div class="bg-white p-8 rounded-xl shadow-sm text-center border border-gray-200">
                    <p class="text-gray-500">The structure for this tournament is still being finalized. Check back soon!</p>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
