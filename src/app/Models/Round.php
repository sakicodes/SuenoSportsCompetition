<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
	protected $fillable = [
		'competition_id',
		'name',
		'sequence',
		'prediction_cost',
		'prediction_reward',
		'prediction_lock_datetime',
		'locked',
	];
	
	protected function casts(): array
	{
		return [
			'prediction_cost' => 'integer',
			'prediction_reward' => 'integer',
			'prediction_lock_datetime' => 'datetime',
			'locked' => 'boolean',
		];
	}

	public function competition()
	{
		return $this->belongsTo(Competition::class);
	}
	
	public function matches()
	{
		return $this->hasMany(Matches::class);
	}
}
