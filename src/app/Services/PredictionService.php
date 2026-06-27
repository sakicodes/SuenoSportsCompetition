<?php

namespace App\Services;

use App\Repositories\PredictionRepository;
use App\Models\Matches; // Note: using your custom Matches model name
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Exception;

class PredictionService
{
    protected PredictionRepository $predictionRepository;

    public function __construct(PredictionRepository $predictionRepository)
    {
        $this->predictionRepository = $predictionRepository;
    }

    public function submitPrediction(Matches $match, array $data)
    {
        $round = $match->round;
        $user = auth()->user();

        // 1. Time Check
        if ($round->locked || Carbon::now()->isAfter($round->prediction_lock_datetime)) {
            abort(403, 'The deadline for this round has passed.');
        }

        // 2. Check if this is an update or a new wager
        $existingPrediction = $user->predictions()->where('match_id', $match->id)->first();

        return DB::transaction(function () use ($match, $data, $user, $round, $existingPrediction) {

            if ($existingPrediction) {
                // UPDATE: Allow team change, but ignore any new point wagers to prevent complex math
                $existingPrediction->update([
                    'predicted_team_id' => $data['predicted_team_id']
                ]);
                return $existingPrediction;
            }

            // NEW WAGER: Balance Check
            if ($data['points_spent'] > $user->current_points) {
                abort(422, 'Insufficient points balance.');
            }

            // 3. Deduct Points & Save User
            $user->current_points -= $data['points_spent'];
            $user->save();

            // 4. Log the Ledger Transaction (Assuming your Phase 3 model)
            $user->pointLedgers()->create([
                'transaction_type' => 'PREDICTION_COST',
		'amount' => -$data['points_spent'],
		'reference_type' => 'App\Models\Matches',
                'reference_id' => $match->id,
                'notes' => "Wager placed on Match ID: {$match->id}",
            ]);

            // 5. Create the Prediction
            $competition = $match->competition;
            $data['user_id'] = $user->id;
            $data['match_id'] = $match->id;

            return $this->predictionRepository->create($data);
	});
    }
}
