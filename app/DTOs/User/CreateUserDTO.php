<?php

namespace App\DTOs\User;

class CreateUserDTO
{
    public string $name;
    public string $email;
    public string $password;
    public array $companyIds;
    public string $role;

    public function __construct(string $name, string $email, string $password, array $companyIds, string $role)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->companyIds = $companyIds;
        $this->role = $role;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            $data['email'],
            $data['password'],
            $data['company_ids'],
            $data['role']
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'company_ids' => $this->companyIds,
            'role' => $this->role,
        ];
    }
}
