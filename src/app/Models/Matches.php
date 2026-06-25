<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matches extends Model
{
	protected $table = 'matches';
	
	protected $fillable = [
		'competition_id',
		'round_id',
		'home_team_id',
		'away_team_id',
		'winner_team_id',
		'match_datetime',
		'status',
	];
	
	protected function casts(): array
	{
		return [
			'match_datetime' => 'datetime',
		];
	}

	public function competition()
	{
		return $this->belongsTo(Competition::class);
	}
	
	public function round()
	{
		return $this->belongsTo(Round::class);
	}
	
	public function homeTeam()
	{
		return $this->belongsTo(Team::class, 'home_team_id');
	}
	
	public function awayTeam()
	{
		return $this->belongsTo(Team::class, 'away_team_id');
	}
	
	public function winnerTeam()
	{
		return $this->belongsTo(Team::class, 'winner_team_id');
	}
	
	public function predictions()
	{
		return $this->hasMany(Prediction::class, 'match_id');
	}
}
