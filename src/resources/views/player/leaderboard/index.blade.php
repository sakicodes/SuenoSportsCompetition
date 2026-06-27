<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Global Leaderboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-center items-end gap-4 mb-12">
                @foreach($leaders->take(3) as $index => $leader)
                    @php
                        $rank = $index + 1;
                        $styles = [
                            1 => 'h-48 bg-yellow-400 text-yellow-900',
                            2 => 'h-40 bg-gray-300 text-gray-700',
                            3 => 'h-32 bg-orange-400 text-orange-900'
                        ];
                    @endphp
                    <div class="w-24 {{ $styles[$rank] }} rounded-t-lg flex flex-col items-center justify-end pb-4 shadow-lg">
                        <span class="text-2xl font-black">#{{ $rank }}</span>
                        <span class="text-xs font-bold uppercase truncate px-2">{{ $leader->username }}</span>
                        <span class="text-sm font-bold">{{ $leader->current_points }} pts</span>
                    </div>
                @endforeach
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <ul role="list" class="divide-y divide-gray-200">
                    @foreach($leaders->skip(3) as $index => $leader)
                        <li>
                            <div class="px-4 py-4 flex items-center sm:px-6">
                                <div class="min-w-0 flex-1 flex items-center">
                                    <div class="text-lg font-bold text-gray-400 w-12">#{{ $index + 4 }}</div>
                                    <div class="min-w-0 flex-1 px-4">
                                        <p class="text-sm font-medium text-indigo-600 truncate">{{ $leader->username }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold text-gray-900">{{ $leader->current_points }} pts</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
</x-app-layout>
