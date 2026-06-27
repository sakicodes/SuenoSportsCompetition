<?php

namespace App\Http\Controllers\Player;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Competition;
use Illuminate\View\View;

class LeaderboardController extends Controller
{
    public function index(): View
    {
        // Fetch users who are not 'admin'
        $leaders = User::where('role', '!=', 'ADMIN')
            ->orderBy('current_points', 'desc')
            ->orderBy('created_at', 'asc')
            ->limit(50)
            ->get();

        return view('player.leaderboard.index', compact('leaders'));
    }

    public function competition(Competition $competition): View
	{
	    // Fetch all users who have predictions in this competition
	    // Sum their 'points_awarded' for all correct predictions
	    $leaders = User::where('role', '!=', 'ADMIN')
		->whereHas('predictions.match', function ($query) use ($competition) {
		    $query->where('competition_id', $competition->id);
		})
		->withSum(['predictions as total_score' => function ($query) {
		    $query->where('status', 'CORRECT');
		}], 'points_awarded')
		->orderByDesc('total_score')
		->get();

	    return view('player.leaderboard.competition', compact('leaders', 'competition'));
	}
}
