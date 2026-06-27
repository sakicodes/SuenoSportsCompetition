<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Matches;
use App\Services\MatchResolutionService;
use Illuminate\Http\Request;

class MatchResolutionController extends Controller
{
    protected MatchResolutionService $resolutionService;

    public function __construct(MatchResolutionService $resolutionService)
    {
        $this->resolutionService = $resolutionService;
    }

    public function resolve(Request $request, Matches $match)
    {
        $validated = $request->validate([
            'winning_team_id' => 'required|exists:teams,id',
        ]);

        // Ensure the winning team actually played in this match
        if (!in_array($validated['winning_team_id'], [$match->home_team_id, $match->away_team_id])) {
            return back()->withErrors(['winning_team_id' => 'Selected team did not play in this match.']);
        }

        $this->resolutionService->resolveMatch($match, $validated['winning_team_id']);

        return back()->with('success', 'Match resolved and points have been distributed!');
    }

    public function cancel(Request $request, Matches $match)
    {
        $this->resolutionService->cancelMatch($match);
        return back()->with('success', 'Match cancelled and wagers refunded.');
    }
}
