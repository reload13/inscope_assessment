<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

interface ProjectRepositoryInterface
{
    /**
     * Get all projects for a given company.
     *
     * @param Company $company
     * @return Collection
     */
    public function getProjectsForCompany(Company $company): Collection;

    /**
     * Get all projects.
     *
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * Create a new project.
     *
     * @param array $data
     * @return Project
     */
    public function createProject(array $data): Project;

    /**
     * Find a project by its ID.
     *
     * @param string $id
     * @return Project
     */
    public function findProjectById(string $id): Project;

    /**
     * Update a project.
     *
     * @param Project $project
     * @param array $data
     * @return Project
     */
    public function updateProject(Project $project, array $data): Project;

    /**
     * Delete a project.
     *
     * @param Project $project
     * @return bool|null
     */
    public function deleteProject(Project $project): ?bool;
}
