<?php

use App\Enums\UserRole;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\post;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);

beforeEach(function () {
    if (!Role::where('name', UserRole::Admin)->exists()) {
        Role::create(['name' => UserRole::Admin]);
    }

    if (!Role::where('name', UserRole::Moderator)->exists()) {
        Role::create(['name' => UserRole::Moderator]);
    }
});

it('allows a moderator to create a project for a company they belong to', function () {
    $moderator = User::factory()->create();
    $company = Company::factory()->create();

    $moderator->companies()->attach($company->id);
    $moderator->assignRole(UserRole::Moderator);

    actingAs($moderator);

    $response = post(route('projects.store', $company->slug), [
        'name' => 'New Project',
        'description' => 'This is a new project',
        'company_id' => $company->id,
        'creator_id' => $moderator->id,
    ]);

    $response->assertRedirect(route('projects.index', $company->slug));
    $this->assertDatabaseHas('projects', [
        'name' => 'New Project',
        'description' => 'This is a new project',
        'company_id' => $company->id,
        'creator_id' => $moderator->id,
    ]);
});

it('forbids users without the required role from creating a project', function () {
    $user = User::factory()->create();  // No role assigned
    $company = Company::factory()->create();

    actingAs($user);

    $response = post(route('projects.store', $company->slug), [
        'name' => 'Unauthorized Project',
        'description' => 'Should not be created',
        'company_id' => $company->id,
    ]);

    $response->assertStatus(403);
    $this->assertDatabaseMissing('projects', [
        'name' => 'Unauthorized Project',
        'company_id' => $company->id,
    ]);
});

it('forbids users from creating a project for a company they do not belong to', function () {
    $user = User::factory()->create();
    $companyUserBelongsTo = Company::factory()->create();
    $companyUserDoesNotBelongTo = Company::factory()->create();

    $user->companies()->attach($companyUserBelongsTo->id);
    $user->assignRole(UserRole::Moderator);  // Moderator role allows project creation

    actingAs($user);

    $response = post(route('projects.store', $companyUserDoesNotBelongTo->slug), [
        'name' => 'Invalid Project',
        'description' => 'Should not be created for a different company',
        'company_id' => $companyUserDoesNotBelongTo->id,
    ]);

    $response->assertStatus(403);
    $this->assertDatabaseMissing('projects', [
        'name' => 'Invalid Project',
        'company_id' => $companyUserDoesNotBelongTo->id,
    ]);
});

it('prevents tampering with the creator_id when creating a project', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $company = Company::factory()->create();

    $user1->companies()->attach($company->id);
    $user1->assignRole(UserRole::Moderator);

    actingAs($user1);

    $response = post(route('projects.store', $company->slug), [
        'name' => 'Tampered Project',
        'description' => 'Trying to set a different creator',
        'company_id' => $company->id,
        'creator_id' => $user2->id,
    ]);

    $this->assertDatabaseHas('projects', [
        'name' => 'Tampered Project',
        'company_id' => $company->id,
        'creator_id' => $user1->id,
    ]);
});
