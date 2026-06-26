<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TeamService;
use Illuminate\Http\Request;

class TeamController extends Controller
{
	protected TeamService $teamService;
	
	public function __construct(TeamService $teamService)
	{
		$this->teamService = $teamService;
	}
	
	public function index()
	{
		$teams = $this->teamService->getAllTeams();
		// We will create this view in the next step
		return view('admin.teams.index', compact('teams'));
	}
	
	public function store(Request $request)
	{
		$validated = $request->validate([
			'name' => 'required|string|max:255|unique:teams',
			'short_name' => 'required|string|max:10|unique:teams',
		]);
		
		$this->teamService->createTeam($validated);
		
		return redirect()->route('admin.teams.index')->with('success', 'Team created successfully!');
	}
}
