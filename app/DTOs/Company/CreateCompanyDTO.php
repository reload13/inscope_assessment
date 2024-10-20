<?php

namespace App\DTOs\Company;

class CreateCompanyDTO
{
    public string $name;
    public string $slug;

    public function __construct(string $name, string $slug)
    {
        $this->name = $name;
        $this->slug = $slug;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            $data['slug'],
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
        ];
    }

}
