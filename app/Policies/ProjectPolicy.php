<?php

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Company;
use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function before(User $user)
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return null;
    }
    /**
     * Determine if the user can view any projects.
     */
    public function viewAny(User $user, Project $project, Company $company)
    {
        return $user->hasAnyRole(UserRole::Moderator) && $user->companies->contains($company);
    }

    /**
     * Determine if the user can view a specific project.
     */
    public function view(User $user, Project $project, Company $company)
    {
        return $user->hasRole(UserRole::Moderator) && $user->companies->contains($company) && $project->company_id === $company->id;
    }

    /**
     * Determine if the user can create a project.
     */
    public function create(User $user, Project $project, Company $company)
    {
        return $user->hasRole(UserRole::Moderator) && $user->companies->contains($company);
    }

    /**
     * Determine if the user can update a project.
     */
    public function update(User $user, Project $project, Company $company)
    {dd($user);
        return $user->hasRole(UserRole::Moderator) && $user->companies->contains($company) && $project->company_id === $company->id;
    }

    /**
     * Determine if the user can delete a project.
     */
    public function delete(User $user, Project $project, Company $company)
    {
        return $user->hasRole(UserRole::Moderator);
    }
}

