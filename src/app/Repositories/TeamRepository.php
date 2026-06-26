<?php

namespace App\Repositories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

class TeamRepository
{
    public function getAll(): Collection
    {
        return Team::orderBy('name')->get();
    }

    public function create(array $data): Team
    {
        return Team::create($data);
    }
}
