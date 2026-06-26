<?php

namespace App\Repositories;

use App\Models\Competition;
use Illuminate\Database\Eloquent\Collection;

class CompetitionRepository
{
    public function getAll(): Collection
    {
        return Competition::orderBy('created_at', 'desc')->get();
    }

    public function create(array $data): Competition
    {
        return Competition::create($data);
    }
}
