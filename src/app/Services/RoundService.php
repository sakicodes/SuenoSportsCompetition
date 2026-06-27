<?php

namespace App\Services;

use App\Repositories\RoundRepository;

class RoundService
{
    protected RoundRepository $roundRepository;

    public function __construct(RoundRepository $roundRepository)
    {
        $this->roundRepository = $roundRepository;
    }

    public function createRound(array $data)
    {
        // Force the round to be unlocked upon creation
        $data['locked'] = false;
        return $this->roundRepository->create($data);
    }
}
