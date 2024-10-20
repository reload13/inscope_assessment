<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Company;
use App\Models\User;

class UserPolicy
{
    public function before(User $user)
    {
        if ($user->hasRole(UserRole::Admin)) {
            return true;
        }

        return null;
    }
    /**
     * Determine if the user can view any users in the company.
     */
    public function viewAny(User $user, User $targetUser, Company $company)
    {
        return $user->hasRole(UserRole::Moderator) && $user->companies->contains($company);
    }

    /**
     * Determine if the user can view a specific user.
     */
    public function view(User $user, User $targetUser, Company $company)
    {
        return $user->hasRole(UserRole::Moderator) && $user->companies->contains($company) && $targetUser->companies->contains($company);
    }

    /**
     * Determine if the user can create a new user.
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine if the user can update a user.
     */
    public function update(User $user, User $targetUser)
    {
        return false;
    }

    /**
     * Determine if the user can delete a user.
     */
    public function delete(User $user, User $targetUser)
    {
        return false;
    }
}
