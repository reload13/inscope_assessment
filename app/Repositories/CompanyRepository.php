<?php

namespace App\Repositories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CompanyRepository implements CompanyRepositoryInterface
{
    /**
     * Get all companies.
     *
     * @return Collection
     */
    public function getAllCompanies(): Collection
    {
        return Company::all();
    }

    /**
     * Create a new company.
     *
     * @param array $data
     * @return Company
     */
    public function createCompany(array $data): Company
    {
        return Company::create($data);
    }

    /**
     * Find a company by its ID.
     *
     * @param string $id
     * @return Company
     *
     * @throws ModelNotFoundException
     */
    public function findCompanyById(string $id): Company
    {
        return Company::findOrFail($id);
    }

    /**
     * Update a company.
     *
     * @param Company $company
     * @param array $data
     * @return Company
     */
    public function updateCompany(Company $company, array $data): Company
    {
        if(isset($data['name'])){
            $company->name = $data['name'];
        }

        $company->slug = $data['slug'];
        $company->save();

        return $company->refresh();
    }

    /**
     * Delete a company.
     *
     * @param Company $company
     * @return bool|null
     *
     * @throws \Exception
     */
    public function deleteCompany(Company $company): ?bool
    {
        return $company->delete();
    }
}
