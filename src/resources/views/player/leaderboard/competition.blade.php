<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $competition->name }} - Leaderboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <ul role="list" class="divide-y divide-gray-200">
                    @foreach($leaders as $index => $leader)
                        <li class="px-4 py-4 flex items-center sm:px-6">
                            <div class="text-lg font-bold text-gray-400 w-12">#{{ $index + 1 }}</div>
                            <div class="min-w-0 flex-1 px-4">
                                <p class="text-sm font-medium text-indigo-600 truncate">{{ $leader->username }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-gray-900">{{ $leader->total_score ?? 0 }} pts</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
