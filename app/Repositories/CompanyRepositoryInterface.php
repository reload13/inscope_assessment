<?php

namespace App\Repositories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;

interface CompanyRepositoryInterface
{
    /**
     * Get all companies.
     *
     * @return Collection
     */
    public function getAllCompanies(): Collection;

    /**
     * Create a new company.
     *
     * @param array $data
     * @return Company
     */
    public function createCompany(array $data): Company;

    /**
     * Find a company by its ID.
     *
     * @param string $id
     * @return Company
     */
    public function findCompanyById(string $id): Company;

    /**
     * Update a company.
     *
     * @param Company $company
     * @param array $data
     * @return Company
     */
    public function updateCompany(Company $company, array $data): Company;

    /**
     * Delete a company.
     *
     * @param Company $company
     * @return bool|null
     */
    public function deleteCompany(Company $company): ?bool;
}
