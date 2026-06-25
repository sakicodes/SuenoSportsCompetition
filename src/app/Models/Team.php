<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
	/** @use HasFactory<\Database\Factories\TeamFactory> */
	use HasFactory;

	protected $fillable = [
		'name',
		'short_name',
		'active',
	];
	
	protected function casts(): array
	{
		return [
			'active' => 'boolean',
		];
	}

	public function homeMatches()
	{
		return $this->hasMany(Matches::class, 'home_team_id');
	}
	
	public function awayMatches()
	{
		return $this->hasMany(Matches::class, 'away_team_id');
	}
	
	public function wonMatches()
	{
		return $this->hasMany(Matches::class, 'winner_team_id');
	}
}
