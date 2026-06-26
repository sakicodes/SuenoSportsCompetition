<?php

namespace App\Services;

use App\Repositories\CompetitionRepository;
use Illuminate\Database\Eloquent\Collection;

class CompetitionService
{
    protected CompetitionRepository $competitionRepository;

    public function __construct(CompetitionRepository $competitionRepository)
    {
        $this->competitionRepository = $competitionRepository;
    }

    public function getAllCompetitions(): Collection
    {
        return $this->competitionRepository->getAll();
    }

    public function createCompetition(array $data)
    {
        $data['status'] = 'OPEN';
        return $this->competitionRepository->create($data);
    }
}
