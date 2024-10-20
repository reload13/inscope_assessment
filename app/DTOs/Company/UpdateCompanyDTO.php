<?php

namespace App\DTOs\Company;

class UpdateCompanyDTO
{
    public ?string $name;
    public string $slug;

    public function __construct(?string $name = null, string $slug)
    {
        $this->name = $name;
        $this->slug = $slug;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'] ?? null,
            $data['slug'],
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name ?? null,
            'slug' => $this->slug,
        ];
    }
}
