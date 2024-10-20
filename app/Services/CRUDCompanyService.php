<?php

namespace App\Services;

use App\Models\Company;
use App\DTOs\Company\UpdateCompanyDTO;
use App\DTOs\Company\CreateCompanyDTO;
use App\Repositories\CompanyRepository;

class CRUDCompanyService
{
    private $companyRepository;

    public function __construct(CompanyRepository $companyRepository){
        $this->companyRepository = $companyRepository;
    }

    public function store(CreateCompanyDTO $companyDTO): Company
    {
        $companyData = $companyDTO->toArray();

        return $this->companyRepository->createCompany($companyData);
    }

    public function update(Company $company, UpdateCompanyDTO $companyDTO): Company
    {
        $companyData = $companyDTO->toArray();

        return $this->companyRepository->updateCompany($company,$companyData);
    }

    public function delete(Company $company): bool
    {
        return $this->companyRepository->deleteCompany($company);
    }
}
