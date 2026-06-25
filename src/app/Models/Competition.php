<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
	/** @use HasFactory<\Database\Factories\CompetitionFactory> */
	use HasFactory;

	protected $fillable = [
		'name',
		'description',
		'status',
		'default_prediction_cost',
		'default_prediction_reward',
	];
	
	protected function casts(): array
	{
		return [
			'default_prediction_cost' => 'integer',
			'default_prediction_reward' => 'integer',
		];
	}

	public function participants()
	{
		return $this->hasMany(CompetitionParticipant::class);
	}
	
	public function rounds()
	{
		return $this->hasMany(Round::class);
	}
	
	public function matches()
	{
		return $this->hasMany(Matches::class);
	}
}
