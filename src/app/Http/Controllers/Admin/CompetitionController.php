<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CompetitionService;
use App\Services\TeamService;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    protected CompetitionService $competitionService;

    public function __construct(CompetitionService $competitionService)
    {
        $this->competitionService = $competitionService;
    }

    public function index()
    {
        $competitions = $this->competitionService->getAllCompetitions();
        return view('admin.competitions.index', compact('competitions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'default_prediction_cost' => 'required|integer|min:0',
            'default_prediction_multiplier' => 'required|integer|min:1',
        ]);

        $this->competitionService->createCompetition($validated);

        return redirect()->route('admin.competitions.index')->with('success', 'Competition created successfully!');
    }

    public function show(\App\Models\Competition $competition, \App\Services\TeamService $teamService)
    {
        // Eager load rounds and matches
        $competition->load([
            'rounds' => function($query) {
                $query->orderBy('sequence', 'asc');
            },
            'matches.homeTeam', 
            'matches.awayTeam',
            'matches.round'
        ]);
        
        $teams = $teamService->getAllTeams();
        
        return view('admin.competitions.show', compact('competition', 'teams'));
    }
}
