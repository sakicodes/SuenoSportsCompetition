<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
	protected $fillable = [
		'user_id',
		'match_id',
		'predicted_team_id',
		'points_spent',
		'points_awarded',
		'status',
	];
	
	protected function casts(): array
	{
		return [
			'points_spent' => 'integer',
			'points_awarded' => 'integer',
		];
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
	
	public function match()
	{
		return $this->belongsTo(Matches::class, 'match_id');
	}
	
	public function predictedTeam()
	{
		return $this->belongsTo(Team::class, 'predicted_team_id');
	}
}
