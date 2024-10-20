<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Company;
use App\Models\User;

class CompanyPolicy
{
    public function before(User $user)
    {
        if ($user->hasRole(UserRole::Admin)) {
            return true;
        }

        return null;
    }
    /**
     * Determine if the user can view any companies.
     * Only admins can view the list of companies.
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine if the user can view the specific company.
     * Users can view the company they belong to.
     */
    public function view(User $user, Company $company)
    {
       //
    }

    /**
     * Determine if the user can create companies.
     * Only admins can create new companies.
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine if the user can update the company.
     * Only admins of the company can update it.
     */
    public function update(User $user, Company $company)
    {
       //
    }

    /**
     * Determine if the user can delete the company.
     * Only admins of the company can delete it.
     */
    public function delete(User $user, Company $company)
    {
        //
    }
}
