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
				<h3 class="text-lg font-medium text-gray-900">Tournament Rounds</h3>
			</div>

			<form method="POST" action="{{ route('admin.rounds.store', $competition) }}" class="mb-8 p-4 bg-gray-50 rounded-md border">
			@csrf
			<h4 class="text-sm font-medium text-gray-700 mb-3">Add New Round</h4>
			
			<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
			    <div>
				<x-input-label for="name" :value="__('Round Name')" />
				<x-text-input id="name" name="name" type="text" class="mt-1 block w-full text-sm" placeholder="e.g., Round of 32" required />
			    </div>
			    <div>
				<x-input-label for="sequence" :value="__('Sequence Order')" />
				<x-text-input id="sequence" name="sequence" type="number" class="mt-1 block w-full text-sm" value="1" required />
			    </div>
			    <div>
				<x-input-label for="prediction_cost" :value="__('Cost (Leave blank for default)')" />
				<x-text-input id="prediction_cost" name="prediction_cost" type="number" class="mt-1 block w-full text-sm" />
			    </div>
			    <div>
				<x-input-label for="prediction_multiplier" :value="__('Multiplier (Leave blank for default)')" />
				<x-text-input id="prediction_multiplier" name="prediction_multiplier" type="number" class="mt-1 block w-full text-sm" />
			    </div>
			    <div class="sm:col-span-2">
				<x-input-label for="prediction_lock_datetime" :value="__('Prediction Lock Deadline')" />
				<x-text-input id="prediction_lock_datetime" name="prediction_lock_datetime" type="datetime-local" class="mt-1 block w-full text-sm" required />
			    </div>
			</div>
			<div class="mt-4">
			    <x-primary-button class="text-xs">{{ __('Save Round') }}</x-primary-button>
			</div>
		    </form>

		    @forelse($competition->rounds as $round)
			<div class="mb-3 p-3 border rounded-md flex justify-between items-center bg-white">
			    <div>
				<div class="font-medium text-gray-900">
				    {{ $round->sequence }}. {{ $round->name }}
				    @if($round->locked)
					<span class="ml-2 px-2 py-0.5 text-xs bg-red-100 text-red-800 rounded-full">Locked</span>
				    @else
					<span class="ml-2 px-2 py-0.5 text-xs bg-green-100 text-green-800 rounded-full">Open</span>
				    @endif
				</div>
				<div class="text-xs text-gray-500 mt-1">
				    Cost: {{ $round->prediction_cost ?? $competition->default_prediction_cost }} | 
				    Multiplier: {{ $round->prediction_multiplier ?? $competition->default_prediction_multiplier }}x |
				    Locks: {{ $round->prediction_lock_datetime->format('M j, Y H:i') }}
				</div>
			    </div>
			</div>
		    @empty
			<p class="text-sm text-gray-500 text-center py-4">No rounds created yet.</p>
		    @endforelse
		</div>

                <div class="bg-white shadow sm:rounded-lg p-6">
		    <div class="flex justify-between items-center mb-4">
			<h3 class="text-lg font-medium text-gray-900">Tournament Matches</h3>
		    </div>

		    <form method="POST" action="{{ route('admin.matches.store', $competition) }}" class="mb-8 p-4 bg-gray-50 rounded-md border">
			@csrf
			<h4 class="text-sm font-medium text-gray-700 mb-3">Add New Match</h4>
			
			<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
			    <div class="sm:col-span-2">
				<x-input-label for="round_id" :value="__('Select Round')" />
				<select id="round_id" name="round_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm" required>
				    <option value="" disabled selected>Choose a round...</option>
				    @foreach($competition->rounds as $round)
					<option value="{{ $round->id }}">{{ $round->name }}</option>
				    @endforeach
				</select>
			    </div>
			    <div>
				<x-input-label for="home_team_id" :value="__('Home Team')" />
				<select id="home_team_id" name="home_team_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm" required>
				    <option value="" disabled selected>Select Team...</option>
				    @foreach($teams as $team)
					<option value="{{ $team->id }}">{{ $team->name }} ({{ $team->short_name }})</option>
				    @endforeach
				</select>
			    </div>
			    <div>
				<x-input-label for="away_team_id" :value="__('Away Team')" />
				<select id="away_team_id" name="away_team_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm" required>
				    <option value="" disabled selected>Select Team...</option>
				    @foreach($teams as $team)
					<option value="{{ $team->id }}">{{ $team->name }} ({{ $team->short_name }})</option>
				    @endforeach
				</select>
			    </div>
			    <div class="sm:col-span-2">
				<x-input-label for="match_datetime" :value="__('Match Date & Time')" />
				<x-text-input id="match_datetime" name="match_datetime" type="datetime-local" class="mt-1 block w-full text-sm" required />
			    </div>
			</div>
			<div class="mt-4">
			    <x-primary-button class="text-xs">{{ __('Save Match') }}</x-primary-button>
			</div>
		    </form>

		    <div class="space-y-3">
			@forelse($competition->matches->sortBy('match_datetime') as $match)
			    <div class="p-3 border rounded-md flex justify-between items-center bg-white">
				<div>
				    <div class="text-xs text-indigo-600 font-bold mb-1">{{ optional($match->round)->name }}</div>
				    <div class="font-medium text-gray-900">
					{{ $match->homeTeam->name }} vs {{ $match->awayTeam->name }}
				    </div>
				    <div class="text-xs text-gray-500 mt-1">
					Kickoff: {{ $match->match_datetime->format('M j, Y H:i') }} | Status: {{ $match->status }}
				    </div>
				</div>
			    </div>
			@empty
			    <p class="text-sm text-gray-500 text-center py-4">No matches created yet.</p>
			@endforelse
		    </div>
		</div>
            </div>

        </div>
    </div>
</x-app-layout>
