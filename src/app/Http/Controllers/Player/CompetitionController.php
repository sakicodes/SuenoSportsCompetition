<?php

namespace App\Http\Controllers\Player;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Services\CompetitionService;
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
        $competitions = $this->competitionService->getActiveCompetitions();
        return view('player.competitions.index', compact('competitions'));
    }

    public function show(Competition $competition)
    {
        // Abort if a player tries to URL-hack into a closed competition
        if ($competition->status !== 'OPEN') {
            abort(403, 'This competition is currently closed.');
        }

        // Eager load the structure for the player lobby
        $competition->load([
            'rounds' => function($query) {
                $query->orderBy('sequence', 'asc');
            },
            'matches.homeTeam', 
            'matches.awayTeam'
        ]);

	$userPredictions = auth()->user()->predictions()
            ->whereIn('match_id', $competition->matches->pluck('id'))
            ->get()
            ->keyBy('match_id'); // Key them by match_id for easy lookup in Blade

        return view('player.competitions.show', compact('competition', 'userPredictions'));
    }
}
