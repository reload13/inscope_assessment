<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProjectRepository implements ProjectRepositoryInterface
{
    public function getProjectsForCompany(Company $company) : Collection
    {
        return $company->projects()->get();
    }
    /**
     * Get all projects.
     *
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Project::all();
    }

    /**
     * Create a new project.
     *
     * @param array $data
     * @return Project
     */
    public function createProject(array $data): Project
    {
        return Project::create($data);
    }

    /**
     * Find a project by its ID.
     *
     * @param string $id
     * @return Project
     *
     * @throws ModelNotFoundException
     */
    public function findProjectById(string $id): Project
    {
        return Project::findOrFail($id);
    }

    /**
     * Update a project.
     *
     * @param Project $project
     * @param array $data
     * @return Project
     */
    public function updateProject(Project $project, array $data): Project
    {
        $project->update($data);

        return $project->refresh();
    }

    /**
     * Delete a project.
     *
     * @param Project $project
     * @return bool|null
     *
     * @throws \Exception
     */
    public function deleteProject(Project $project): ?bool
    {
        return $project->delete();
    }
}
