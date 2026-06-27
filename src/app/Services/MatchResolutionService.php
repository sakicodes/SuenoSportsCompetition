<?php

namespace App\Services;

use App\Models\Matches;
use Illuminate\Support\Facades\DB;
use Exception;

class MatchResolutionService
{
    public function resolveMatch(Matches $match, int $winningTeamId)
    {
        return DB::transaction(function () use ($match, $winningTeamId) {
            
            // 1. Fetch all PENDING predictions for this specific match
            $predictions = $match->predictions()->where('status', 'PENDING')->get();
            
            // 2. Get the multiplier (Round specific, fallback to Competition default)
            $multiplier = $match->round->prediction_multiplier 
                ?? $match->competition->default_prediction_multiplier;

            foreach ($predictions as $prediction) {
                $user = $prediction->user;

                if ($prediction->predicted_team_id == $winningTeamId) {
                    // THEY WON! Calculate reward
                    $reward = $prediction->points_spent * $multiplier;

                    // Update Prediction Record
                    $prediction->update([
                        'status' => 'CORRECT',
                        'points_awarded' => $reward
                    ]);

                    // Update User Wallet
                    $user->current_points += $reward;
                    $user->save();

                    // Log to Ledger using your exact ENUM
                    $user->pointLedgers()->create([
                        'transaction_type' => 'PREDICTION_REWARD',
                        'amount' => $reward,
                        'reference_type' => 'App\Models\Matches',
                        'reference_id' => $match->id,
                        'notes' => "Won prediction on Match ID: {$match->id} (Multiplier: {$multiplier}x)",
                    ]);
                } else {
                    // THEY LOST. The points were already deducted when they placed the wager.
                    $prediction->update([
                        'status' => 'INCORRECT',
                        'points_awarded' => 0
                    ]);
                }
            }

	    // Update the match status to prevent double-scoring
            $match->update([
                'status' => 'COMPLETED' // Or whatever your closed status string is in the DB
	    ]);

            return true;
        });
    }

    public function cancelMatch(Matches $match)
    {
        return DB::transaction(function () use ($match) {
            $predictions = $match->predictions()->where('status', 'PENDING')->get();

            foreach ($predictions as $prediction) {
                $user = $prediction->user;

                $user->current_points += $prediction->points_spent;
                $user->save();

                $user->pointLedgers()->create([
                    'transaction_type' => 'ADMIN_ADJUSTMENT', // Using your available ENUM for refunds
                    'amount' => $prediction->points_spent,
                    'reference_type' => 'App\Models\Matches',
                    'reference_id' => $match->id,
                    'notes' => "Refund - Match ID: {$match->id} was cancelled.",
		]);

		$prediction->delete();
            }

	    // Update the match status
            $match->update([
                'status' => 'CLOSED'
	    ]);

            return true;
        });
    }
}
