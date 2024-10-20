<?php

namespace App\Http\Controllers;

use App\DTOs\Project\CreateProjectDTO;
use App\DTOs\Project\UpdateProjectDTO;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Company;
use App\Models\Project;
use App\Repositories\ProjectRepository;
use App\Services\CRUDProjectService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Company $company, ProjectRepository $projectRepository): View
    {
        $this->authorize('viewAny', [new Project, $company]);

        $projects = $projectRepository->getProjectsForCompany($company);

        return view('projects.index', compact('projects', 'company'));
    }

    public function show(Company $company, Project $project): View
    {
        $this->authorize('view', [$project, $company]);

        return view('projects.show', compact('project', 'company'));
    }

    public function create(Company $company): View
    {
        $this->authorize('create', [new Project, $company]);

        return view('projects.create', compact('company'));
    }

    public function store(StoreProjectRequest $request, Company $company, CRUDProjectService $service): RedirectResponse
    {
        $this->authorize('create', [new Project, $company]);

        $dto = CreateProjectDTO::fromArray([...$request->validated(), 'company_id' => $company->id, 'creator_id' => auth()->user()->id]);
        $service->store($dto);

        return redirect()->route('projects.index', $company->slug)->with('success', 'Project created successfully.');
    }

    public function edit(Company $company, Project $project): View
    {
        $this->authorize('update', [$project, $company]);

        return view('projects.edit', compact('project', 'company'));
    }

    public function update(UpdateProjectRequest $request, Company $company, Project $project, CRUDProjectService $service): RedirectResponse
    {
        $this->authorize('update', [$project, $company]);

        $dto = UpdateProjectDTO::fromArray($request->validated());
        $service->update($project, $dto);

        return redirect()->route('projects.index', $company->slug)->with('success', 'Project updated successfully.');
    }

    public function destroy(Company $company, Project $project, CRUDProjectService $projectService): RedirectResponse
    {
        $this->authorize('delete', [$project, $company]);

        $projectService->delete($project);

        return redirect()->route('projects.index', $company->slug)->with('success', 'Project deleted successfully.');
    }
}
