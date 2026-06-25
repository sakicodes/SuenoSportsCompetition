<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPointsLedger extends Model
{
	protected $fillable = [
		'user_id',
		'amount',
		'transaction_type',
		'reference_type',
		'reference_id',
		'notes',
	];
	
	protected function casts(): array
	{
		return [
			'amount' => 'integer',
		];
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
