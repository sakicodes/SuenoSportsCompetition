<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    public function getAllUsers(): Collection
    {
        return User::where('role', 'USER')->orderBy('name')->get();
    }

    public function create(array $data): User
    {
        return User::create($data);
    }
}
