<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CompanyFactory extends Factory
{

    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'slug' => Str::slug($this->faker->unique()->company),
        ];
    }
}
