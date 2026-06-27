<?php

namespace App\Services;

use App\Repositories\MatchRepository;

class MatchService
{
    protected MatchRepository $matchRepository;

    public function __construct(MatchRepository $matchRepository)
    {
        $this->matchRepository = $matchRepository;
    }

    public function createMatch(array $data)
    {
        $data['status'] = 'OPEN';
        return $this->matchRepository->create($data);
    }
}
