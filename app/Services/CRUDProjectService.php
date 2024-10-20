<?php

namespace App\Services;

use App\Models\Project;
use App\DTOs\Project\CreateProjectDTO;
use App\DTOs\Project\UpdateProjectDTO;
use App\Repositories\ProjectRepository;

class CRUDProjectService
{
    protected $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * Store a new project.
     */
    public function store(CreateProjectDTO $projectDTO): Project
    {
        $projectData = $projectDTO->toArray();

        return $this->projectRepository->createProject($projectData);
    }

    /**
     * Update an existing project.
     */
    public function update(Project $project, UpdateProjectDTO $projectDTO): Project
    {
        $projectData = $projectDTO->toArray();

        return $this->projectRepository->updateProject($project, $projectData);
    }

    public function delete(Project $project): bool
    {
        return $this->projectRepository->deleteProject($project);
    }

}
