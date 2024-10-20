<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    /**
     * Get all users for a given company.
     *
     * @param Company $company
     * @return Collection
     */
    public function getUsersForCompany(Company $company): Collection;

    /**
     * Get all users.
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Create a new user.
     *
     * @param array $data
     * @return User
     */
    public function create(array $data): User;

    /**
     * Find a user by ID.
     *
     * @param int $id
     * @return User
     */
    public function findById(int $id): User;

    /**
     * Update an existing user.
     *
     * @param User $user
     * @param array $data
     * @return User
     */
    public function update(User $user, array $data): User;

    /**
     * Delete a user.
     *
     * @param User $user
     * @return bool|null
     */
    public function deleteUser(User $user): ?bool;
}
