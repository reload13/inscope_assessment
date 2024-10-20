<?php

// UserRepository.php

namespace App\Repositories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function getUsersForCompany(Company $company): Collection
    {
        return $company->users()->get();
    }
    /**
     * Get all users.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return User::all();
    }

    /**
     * Create a new user.
     *
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        $user = User::create($data);

        // Optionally assign a role
        if (isset($data['role'])) {
            $user->assignRole($data['role']);
        }

        if (isset($data['company_ids'])) {
            $user->companies()->attach($data['company_ids']);
        }

        return $user;
    }

    /**
     * Find a user by ID.
     *
     * @param int $id
     * @return User
     */
    public function findById(int $id): User
    {
        return User::findOrFail($id);
    }

    /**
     * Update an existing user.
     *
     * @param User $user
     * @param array $data
     * @return User
     */
    public function update(User $user, array $data): User
    {
        if (isset($data['name'])) {
            $user->name = $data['name'];
        }

        if (isset($data['email'])) {
            $user->email = $data['email'];
        }

        if (isset($data['password'])) {
            $user->password = $data['password'];
        }

        $user->save();

        if (isset($data['role'])) {
            $user->syncRoles([$data['role']]);
        }

        if (isset($data['company_ids'])) {
            $user->companies()->sync($data['company_ids']);
        }

        return $user;
    }

    /**
     * Delete a user.
     *
     * @param User $user
     * @return bool|null
     */
    public function deleteUser(User $user): ?bool
    {
        return $user->delete();
    }
}
