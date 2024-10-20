<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use Illuminate\Support\Str;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create 10 companies
        for ($i = 1; $i <= 10; $i++) {
            $name = 'Company ' . $i;
            Company::create([
                'id' => Str::ulid(),
                'name' => $name,
                'slug' => Str::slug($name . '-' . Str::random(6)),
            ]);
        }
    }
}
