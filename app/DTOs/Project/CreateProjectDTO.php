<?php

namespace App\DTOs\Project;

class CreateProjectDTO
{
    public string $name;
    public string $description;
    public string $creatorId;
    public string $companyId;

    public function __construct(string $name, string $description, string $creatorId, string $companyId)
    {
        $this->name = $name;
        $this->description = $description;
        $this->creatorId = $creatorId;
        $this->companyId = $companyId;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            $data['description'],
            $data['creator_id'],
            $data['company_id']
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'creator_id' => $this->creatorId,
            'company_id' => $this->companyId,
        ];
    }
}
