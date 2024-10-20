<?php

use App\Enums\UserRole;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use function Pest\Laravel\get;
use function Pest\Laravel\put;
use function Pest\Laravel\post;
use function Pest\Laravel\delete;
use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

beforeEach(function () {

    if (!Role::where('name', UserRole::Admin)->exists()) {
        Role::create(['name' => UserRole::Admin]);
    }

    if (!Role::where('name', UserRole::Moderator)->exists()) {
        Role::create(['name' => UserRole::Moderator]);
    }

});
describe('Admin User Access', function () {
// Test index action
    it('displays the list of companies', function () {

        $this->user = User::factory()->create();
        $this->user->assignRole(UserRole::Admin);

        // Authenticate the user for all tests
        actingAs($this->user);
        Company::factory()->count(3)->create();
        $response = get(route('companies.index'));
        $response->assertStatus(200);
        $response->assertViewIs('companies.index');
        $response->assertViewHas('companies');
    });

// Test show action
    it('displays a single company', function () {
        $this->user = User::factory()->create();
        $this->user->assignRole(UserRole::Admin);
        actingAs($this->user);
        $company = Company::factory()->create();
        $response = get(route('companies.show', $company));
        $response->assertStatus(200);
        $response->assertViewIs('companies.show');
        $response->assertViewHas('company', $company);
    });

// Test store action
    it('creates a new company', function () {
        $this->user = User::factory()->create();
        $this->user->assignRole(UserRole::Admin);

        // Authenticate the user for all tests
        actingAs($this->user);
        $company = Company::factory()->create();
        $randomSlug = 'new-company-slug-' . Str::random(8);
        $response = post(route('companies.store'), [
            'name' => 'New Company',
            'slug' => $randomSlug,
        ]);

        $response->assertRedirect(route('companies.index'));
        $response->assertSessionHas('success', 'Company created successfully.');
        $this->assertDatabaseHas('companies', ['name' => 'New Company', 'slug' => $randomSlug]);
    });

// Test update action
    it('updates an existing company', function () {
        $this->user = User::factory()->create();
        $this->user->assignRole(UserRole::Admin);

        actingAs($this->user);

        $company = Company::factory()->create(['name' => 'Old Company Name', 'slug' => 'old-company-slug']);

        $randomSlug = 'new-company-slug-' . Str::random(8);

        $response = put(route('companies.update', $company->slug), [
            'name' => 'Updated Company Name',
            'slug' => $randomSlug,
        ]);

        $response->assertRedirect(route('companies.index'));
        $response->assertSessionHas('success', 'Company updated successfully.');
        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
            'name' => 'Updated Company Name',
            'slug' => $randomSlug,
        ]);
    });

// Test destroy action
    it('deletes a company', function () {
        $this->user = User::factory()->create();
        $this->user->assignRole(UserRole::Admin);

        // Authenticate the user for all tests
        actingAs($this->user);
        $user = User::factory()->create();

        $company = Company::factory()->create();

        $response = delete(route('companies.destroy', $company));
        $response->assertRedirect(route('companies.index', $company->slug));
        $response->assertSessionHas('success', 'Company deleted successfully.');
        $this->assertDatabaseMissing('companies', ['id' => $company->id]);
    });
});
describe('Moderator User Access', function () {
    it('does not allow to view the list of companies', function () {
        // Create a moderator user and authenticate
        $moderatorUser = User::factory()->create();
        $moderatorUser->assignRole(UserRole::Moderator);
        actingAs($moderatorUser);

        $response = get(route('companies.index'));

        $response->assertStatus(403); // Forbidden
    });

    it('does not allow to create a new company', function () {
        // Create a moderator user and authenticate
        $moderatorUser = User::factory()->create();
        $moderatorUser->assignRole(UserRole::Moderator);
        actingAs($moderatorUser);

        $response = post(route('companies.store'), [
            'name' => 'New Company',
            'slug' => 'new-company-slug',
        ]);

        $response->assertStatus(403); // Forbidden
    });

    it('does not allow to update a company', function () {
        $company = Company::factory()->create([
            'name' => 'Old Company Name',
            'slug' => 'old-company-slug',
        ]);

        // Create a moderator user and authenticate
        $moderatorUser = User::factory()->create();
        $moderatorUser->assignRole(UserRole::Moderator);
        actingAs($moderatorUser);

        $response = put(route('companies.update', $company), [
            'name' => 'Updated Company Name',
            'slug' => 'updated-company-slug',
        ]);

        $response->assertStatus(403); // Forbidden
    });

    it('does not allow to delete a company', function () {
        $company = Company::factory()->create();

        // Create a moderator user and authenticate
        $moderatorUser = User::factory()->create();
        $moderatorUser->assignRole(UserRole::Moderator);
        actingAs($moderatorUser);

        $response = delete(route('companies.destroy', $company));

        $response->assertStatus(403); // Forbidden
    });
});
