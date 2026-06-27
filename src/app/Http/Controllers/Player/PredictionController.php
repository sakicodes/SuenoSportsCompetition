<?php

namespace App\Http\Controllers\Player;

use App\Http\Controllers\Controller;
use App\Models\Matches;
use App\Services\PredictionService;
use Illuminate\Http\Request;

class PredictionController extends Controller
{
    protected PredictionService $predictionService;

    public function __construct(PredictionService $predictionService)
    {
        $this->predictionService = $predictionService;
    }

    public function store(Request $request, Matches $match)
    {
        $validated = $request->validate([
            'predicted_team_id' => 'required|exists:teams,id',
            'points_spent' => 'required|integer|min:1',
        ]);

        if (!in_array($validated['predicted_team_id'], [$match->home_team_id, $match->away_team_id])) {
            return back()->withErrors(['predicted_team_id' => 'Invalid team selection.']);
        }

        try {
            $this->predictionService->submitPrediction($match, $validated);
            return back()->with('success', 'Prediction and wager locked in successfully!');
        } catch (\Exception $e) {
            // Catch the 422 abort or any DB transaction errors
            return back()->withErrors(['points_spent' => $e->getMessage()]);
        }
    }
}
