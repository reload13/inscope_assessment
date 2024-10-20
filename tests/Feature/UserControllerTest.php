<?php

use App\Enums\UserRole;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\put;
use function Pest\Laravel\delete;
use function Pest\Laravel\actingAs;

// Create roles before running the tests
beforeEach(function () {
    if (!Role::where('name', UserRole::Admin)->exists()) {
        Role::create(['name' => UserRole::Admin]);
    }

    if (!Role::where('name', UserRole::Moderator)->exists()) {
        Role::create(['name' => UserRole::Moderator]);
    }
});

describe('Admin User Access', function () {
    it('allows an admin to view the list of users', function () {
        $admin = User::factory()->create();
        $admin->assignRole(UserRole::Admin);

        $company = Company::factory()->create();
        $users = User::factory()->count(3)->create();

        actingAs($admin);

        $response = get(route('users.index', $company->slug));

        $response->assertStatus(200);
        $response->assertViewIs('users.index');
        $response->assertViewHas('users');
    });

    it('allows an admin to create a user', function () {
        $admin = User::factory()->create();
        $admin->assignRole(UserRole::Admin);

        $company = Company::factory()->create();

        actingAs($admin);

        $response = post(route('users.store', $company->slug), [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password',
            'role' => UserRole::Moderator,
            'company_ids' => [$company->id],
        ]);

        $response->assertRedirect(route('users.index', $company->slug));
        $response->assertSessionHas('success', 'User created successfully.');
        $this->assertDatabaseHas('users', ['email' => 'newuser@example.com']);
    });

    it('allows an admin to update a user', function () {
        $admin = User::factory()->create();
        $admin->assignRole(UserRole::Admin);

        $company = Company::factory()->create();
        $user = User::factory()->create();

        actingAs($admin);

        $response = put(route('users.update', [$company->slug, $user->id]), [
            'name' => 'Updated User Name',
            'email' => $user->email,
            'role' => UserRole::Moderator,
            'company_ids' => [$company->id],
        ]);

        $response->assertRedirect(route('users.index', $company->slug));
        $response->assertSessionHas('success', 'User updated successfully.');
        $this->assertDatabaseHas('users', ['name' => 'Updated User Name']);
    });

    it('allows an admin to delete a user', function () {
        $admin = User::factory()->create();
        $admin->assignRole(UserRole::Admin);

        $company = Company::factory()->create();
        $user = User::factory()->create();

        actingAs($admin);

        $response = delete(route('users.destroy', [$company->slug, $user->id]));

        $response->assertRedirect(route('users.index', $company->slug));
        $response->assertSessionHas('success', 'User deleted successfully.');
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    });
});

describe('Moderator User Access', function () {
    it('allows a moderator to view the list of users', function () {
        $moderator = User::factory()->create();
        $moderator->assignRole(UserRole::Moderator);

        $company = Company::factory()->create();
        $moderator->companies()->attach($company->id); // Moderator belongs to the company

        actingAs($moderator);

        $response = get(route('users.index', $company->slug));

        $response->assertStatus(200);
        $response->assertViewIs('users.index');
        $response->assertViewHas('users');
    });

    it('allows a moderator to view a single user', function () {
        $moderator = User::factory()->create();
        $moderator->assignRole(UserRole::Moderator);

        $company = Company::factory()->create();
        $moderator->companies()->attach($company->id);

        $user = User::factory()->create();

        actingAs($moderator);

        $response = get(route('users.show', [$company->slug, $moderator->id]));

        $response->assertStatus(200);
        $response->assertViewIs('users.show');
        $response->assertViewHas('user');
    });

    it('forbids a moderator from creating a user', function () {
        $moderator = User::factory()->create();
        $moderator->assignRole(UserRole::Moderator);

        $company = Company::factory()->create();
        $moderator->companies()->attach($company->id);

        actingAs($moderator);

        $response = post(route('users.store', $company->slug), [
            'name' => 'Unauthorized User',
            'email' => 'unauthorized@example.com',
            'password' => 'password',
            'role' => UserRole::Moderator,
            'company_ids' => [$company->id],
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('users', ['email' => 'unauthorized@example.com']);
    });

    it('forbids a moderator from updating a user', function () {
        $moderator = User::factory()->create();
        $moderator->assignRole(UserRole::Moderator);

        $company = Company::factory()->create();
        $moderator->companies()->attach($company->id);

        $user = User::factory()->create();

        actingAs($moderator);

        $response = put(route('users.update', [$company->slug, $user->id]), [
            'name' => 'Unauthorized Update',
            'email' => $user->email,
            'role' => UserRole::Moderator,
            'company_ids' => [$company->id],
        ]);

        $response->assertStatus(403); // Forbidden
        $this->assertDatabaseMissing('users', ['name' => 'Unauthorized Update']);
    });

    it('forbids a moderator from deleting a user', function () {
        $moderator = User::factory()->create();
        $moderator->assignRole(UserRole::Moderator);

        $company = Company::factory()->create();
        $moderator->companies()->attach($company->id);

        $user = User::factory()->create();

        actingAs($moderator);

        $response = delete(route('users.destroy', [$company->slug, $moderator->id]));

        $response->assertStatus(403); // Forbidden
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    });
});
