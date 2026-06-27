<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllRegularUsers(): Collection
    {
        return $this->userRepository->getAllUsers();
    }

    public function createUser(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'USER';
        $data['current_points'] = 0;
        $data['first_login'] = true;
        $data['active'] = true;
        
        return $this->userRepository->create($data);
    }
}
