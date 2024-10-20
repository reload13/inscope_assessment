<?php

namespace App\DTOs\User;

use Illuminate\Support\Facades\Hash;

class UpdateUserDTO
{
    public ?string $name;
    public string $email;
    public ?string $password;
    public ?array $companyIds;
    public string $role;

    public function __construct(?string $name = null, string $email, ?string $password = null, ?array $companyIds = null, string $role)
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
            $data['name'] ?? null,
            $data['email'],
            $data['password'] ?? null,
            $data['company_ids'] ?? null,
            $data['role']
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name ?? null,
            'email' => $this->email,
            'password' => $this->password ?? null,
            'company_ids' => $this->companyIds ?? null,
            'role' => $this->role,
        ];
    }
}
