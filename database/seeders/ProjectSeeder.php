<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Company;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $creator = User::first();

        // Assign 3 projects to each company
        $companies = Company::all();
        foreach ($companies as $company) {
            for ($i = 1; $i <= 3; $i++) {
                Project::create([
                    'id' => Str::ulid(),
                    'name' => 'Project ' . $i . ' for ' . $company->name,
                    'description' => 'Description for Project ' . $i,
                    'company_id' => $company->id,
                    'creator_id' => $creator->id,
                ]);
            }
        }
    }
}
