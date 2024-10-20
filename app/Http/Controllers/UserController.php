<?php

namespace App\Http\Controllers;

use App\DTOs\User\CreateUserDTO;
use App\DTOs\User\UpdateUserDTO;
use App\Enums\UserRole;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Company;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\CRUDUserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Company $company, UserRepository $userRepository): View
    {
        $this->authorize('viewAny', [new User, $company]);

        $users = $userRepository->getUsersForCompany($company);
        return view('users.index', compact('users', 'company'));
    }

    public function show(Company $company, User $user): View
    {
        $this->authorize('view', [$user, $company]);

        return view('users.show', compact('user', 'company'));
    }

    public function create(Company $company): View
    {
        $this->authorize('create', [new User, $company]);

        $roles = UserRole::getInstances();
        $companies = Company::all();

        return view('users.create', compact('company', 'roles', 'companies'));
    }

    public function store(StoreUserRequest $request, Company $company, CRUDUserService $userService): RedirectResponse
    {
        $this->authorize('create', [new User, $company]);

        $dto = CreateUserDTO::fromArray($request->validated());
        $userService->store($dto);

        return redirect()->route('users.index', $company->slug)->with('success', 'User created successfully.');
    }

    public function edit(Company $company, User $user): View
    {
        $this->authorize('update', [$user, $company]);

        $roles = UserRole::getInstances();
        $companies = Company::all();

        return view('users.edit', compact('user', 'company', 'roles', 'companies'));
    }

    public function update(UpdateUserRequest $request, Company $company, User $user, CRUDUserService $userService): RedirectResponse
    {
        $this->authorize('update', [$user, $company]);

        $dto = UpdateUserDTO::fromArray($request->validated());

        $userService->update($user, $dto);

        return redirect()->route('users.index', $company->slug)->with('success', 'User updated successfully.');
    }

    public function destroy(Company $company, User $user, CRUDUserService $userService): RedirectResponse
    {
        $this->authorize('delete', [$user, $company]);

        $userService->delete($user);

        return redirect()->route('users.index', $company->slug)->with('success', 'User deleted successfully.');
    }
}
