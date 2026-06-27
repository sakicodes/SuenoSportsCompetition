<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use App\Services\MatchService;
use Illuminate\Http\Request;

class MatchController extends Controller
{
	protected MatchService $matchService;

	public function __construct(MatchService $matchService)
	{
		$this->matchService = $matchService;
	}

	public function store(Request $request, Competition $competition)
	{
		$validated = $request->validate([
			'round_id' => 'required|exists:rounds,id',
			'home_team_id' => 'required|exists:teams,id|different:away_team_id',
			'away_team_id' => 'required|exists:teams,id',
			'match_datetime' => 'required|date',
		]);
		
		$validated['competition_id'] = $competition->id;
		
		$this->matchService->createMatch($validated);
		
		return redirect()->route('admin.competitions.show', $competition)
		   ->with('success', 'Match created successfully!');
	}
}
