<?php

namespace App\Services;

use App\Repositories\TeamRepository;
use Illuminate\Database\Eloquent\Collection;

class TeamService
{
    protected TeamRepository $teamRepository;

    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    public function getAllTeams(): Collection
    {
        return $this->teamRepository->getAll();
    }

    public function createTeam(array $data)
    {
        // Force the active status to true by default when creating
        $data['active'] = true;
        return $this->teamRepository->create($data);
    }
}
