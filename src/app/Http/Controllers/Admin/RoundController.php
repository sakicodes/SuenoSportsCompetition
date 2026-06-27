<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Competition;
use App\Services\RoundService;

class RoundController extends Controller
{
	protected RoundService $roundService;
	
	public function __construct(RoundService $roundService)
	{
		$this->roundService = $roundService;
	}
	
	public function store(Request $request, Competition $competition)
	{
		$validated = $request->validate([
			'name' => 'required|string|max:255',
			'sequence' => 'required|integer|min:1',
			'prediction_cost' => 'nullable|integer|min:0',
			'prediction_multiplier' => 'nullable|integer|min:1',
			'prediction_lock_datetime' => 'required|date',
		]);
		
		// Attach the competition ID to the validated data
		$validated['competition_id'] = $competition->id;
		
		$this->roundService->createRound($validated);
		
		return redirect()->route('admin.competitions.show', $competition)
		   ->with('success', 'Round created successfully!');
	}
}
