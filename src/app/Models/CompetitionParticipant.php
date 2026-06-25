<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompetitionParticipant extends Model
{
	protected $fillable = [
		'competition_id',
		'user_id',
		'joined_at',
	];
	
	protected function casts(): array
	{
		return [
			'joined_at' => 'datetime',
		];
	}
}
