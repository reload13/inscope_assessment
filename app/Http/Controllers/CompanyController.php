<?php

namespace App\Http\Controllers;

use App\DTOs\Company\CreateCompanyDTO;
use App\DTOs\Company\UpdateCompanyDTO;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use App\Repositories\CompanyRepository;
use App\Services\CRUDCompanyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function index(CompanyRepository $companyRepository): View
    {
        $companies = $companyRepository->getAllCompanies();

        return view('companies.index', compact('companies'));
    }

    public function show(Company $company): View
    {
        $this->authorize('view', $company);

        return view('companies.show', compact('company'));
    }

    public function create(): View
    {
        return view('companies.create');
    }

    public function store(StoreCompanyRequest $request, CRUDCompanyService $service): RedirectResponse
    {
        $dto = CreateCompanyDTO::fromArray($request->validated());

        $service->store($dto);

        return redirect()->route('companies.index')->with('success', 'Company created successfully.');
    }

    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    public function update(UpdateCompanyRequest $request, Company $company, CRUDCompanyService $service): RedirectResponse
    {
        $dto = UpdateCompanyDTO::fromArray($request->validated());

        $service->update($company, $dto);

        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
    }

    public function destroy(Company $company, CRUDCompanyService $service): RedirectResponse
    {
        $service->delete($company);

        return redirect()->route('companies.index',$company->slug)->with('success', 'Company deleted successfully.');
    }

    public function userDashboard(Company $company): View
    {
        return view('users.dashboard', compact('company'));
    }
    public function selectCompany(): View
    {
        $companies = auth()->user()->companies;

        return view('companies.select', compact('companies'));
    }
}
