<?php

namespace App\Services;

use App\Models\User;
use App\DTOs\User\CreateUserDTO;
use App\DTOs\User\UpdateUserDTO;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;

class CRUDUserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function store(CreateUserDTO $userDTO): User
    {
        return DB::transaction(function () use ($userDTO) {
            $data = $userDTO->toArray();

            $user = $this->userRepository->create($data);

            return $user;
        });
    }

    public function update(User $user, UpdateUserDTO $userDTO): User
    {
        return DB::transaction(function () use ($user, $userDTO) {
            $data = $userDTO->toArray();

            $user = $this->userRepository->update($user, $data);

            return $user;
        });
    }

    public function delete(User $user): bool
    {
        return $this->userRepository->deleteUser($user);
    }
}
