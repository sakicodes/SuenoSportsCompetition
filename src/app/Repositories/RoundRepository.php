<?php

namespace App\Repositories;

use App\Models\Round;

class RoundRepository
{
    public function create(array $data): Round
    {
        return Round::create($data);
    }
}
