<?php

namespace App\Repositories;

use App\Models\Prediction;

class PredictionRepository
{
    public function create(array $data): Prediction
    {
        // Use updateOrCreate so a user can change their prediction before the lock deadline
        return Prediction::updateOrCreate(
            [
                'user_id' => $data['user_id'],
                'match_id' => $data['match_id'],
            ],
            [
                'predicted_team_id' => $data['predicted_team_id'],
                // These points are locked in at the time of prediction, in case Admin changes default settings later
                'points_spent' => $data['points_spent'],
                'status' =>'PENDING',
            ]
        );
    }
}
