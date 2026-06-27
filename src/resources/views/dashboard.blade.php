<x-app-layout>
    <!-- Hero Banner Header -->
    <x-slot name="header">
        <div class="relative overflow-hidden rounded-lg shadow-md bg-cover bg-center h-48 sm:h-64" style="background-image: url('https://images.unsplash.com/photo-1518605368461-1e122b54d6f7?q=80&w=1200');">
            <!-- Dark gradient overlay for text readability -->
            <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/60 to-transparent"></div>
            
            <!-- Hero Content -->
            <div class="absolute inset-0 p-6 sm:p-10 flex flex-col justify-center z-10 text-white">
                <h2 class="font-black text-3xl sm:text-4xl tracking-tight uppercase">
                    Sueño Sports
                </h2>
                <p class="mt-2 text-gray-200 max-w-xl text-sm sm:text-base">
                    @if(auth()->user()->role === 'ADMIN')
                        Administrator Control Center. Manage tournaments, teams, and player ledgers.
                    @else
                        Welcome back, {{ auth()->user()->name }}. Lock in your predictions and climb the global leaderboard.
                    @endif
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(auth()->user()->role === 'ADMIN')
                <!-- ==========================================
                     ADMINISTRATOR HUB
                     ========================================== -->
                <div class="mb-6">
                    <h3 class="text-gray-500 text-sm font-bold uppercase tracking-wider mb-4">Admin Controls</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        <!-- Competitions Card -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-indigo-500 flex flex-col justify-between">
                            <div>
                                <h4 class="text-lg font-bold text-gray-900 mb-2">Competitions</h4>
                                <p class="text-sm text-gray-600 mb-6">Create tournaments, configure rounds, and schedule matches.</p>
                            </div>
                            <a href="{{ route('admin.competitions.index') }}" class="text-center w-full px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                                Manage Competitions
                            </a>
                        </div>

                        <!-- Teams Card -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-blue-500 flex flex-col justify-between">
                            <div>
                                <h4 class="text-lg font-bold text-gray-900 mb-2">Teams</h4>
                                <p class="text-sm text-gray-600 mb-6">Populate the global database with real-world sports teams.</p>
                            </div>
                            <a href="{{ route('admin.teams.index') }}" class="text-center w-full px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                                Manage Teams
                            </a>
                        </div>

                        <!-- Users Card -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-green-500 flex flex-col justify-between">
                            <div>
                                <h4 class="text-lg font-bold text-gray-900 mb-2">Players</h4>
                                <p class="text-sm text-gray-600 mb-6">Generate player accounts and manage point ledgers.</p>
                            </div>
                            <a href="{{ route('admin.users.index') }}" class="text-center w-full px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition">
                                Manage Players
                            </a>
                        </div>

                    </div>
                </div>
            @else
                <!-- ==========================================
                     PLAYER HUB
                     ========================================== -->
                <div class="mb-6">
                    <div class="flex justify-between items-end mb-4 border-b pb-2">
                        <h3 class="text-gray-500 text-sm font-bold uppercase tracking-wider">Player Lobby</h3>
                        <div class="text-sm text-gray-600 bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100">
                            Balance: <span class="font-bold text-indigo-700">{{ auth()->user()->current_points }} pts</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Play / Predict Card -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-indigo-500 flex flex-col justify-between">
                            <div>
                                <h4 class="text-lg font-bold text-gray-900 mb-2">Tournaments</h4>
                                <p class="text-sm text-gray-600 mb-6">View active competitions, upcoming matches, and lock in your predictions.</p>
                            </div>
                            <!-- Phase 5 Link Placeholders -->
                            <a href="#" class="text-center w-full px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition opacity-50 cursor-not-allowed">
                                View Tournaments
                            </a>
                        </div>

                        <!-- Leaderboard Card -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-gray-800 flex flex-col justify-between">
                            <div>
                                <h4 class="text-lg font-bold text-gray-900 mb-2">Global Leaderboard</h4>
                                <p class="text-sm text-gray-600 mb-6">Check your rank against your friends and view the point ledger.</p>
                            </div>
                            <!-- Phase 6 Link Placeholders -->
                            <a href="#" class="text-center w-full px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-900 transition opacity-50 cursor-not-allowed">
                                View Rankings
                            </a>
                        </div>

                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
