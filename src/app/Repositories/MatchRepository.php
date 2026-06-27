<?php

namespace App\Repositories;

use App\Models\Matches;

class MatchRepository
{
    public function create(array $data): Matches
    {
        return Matches::create($data);
    }
}
