<?php

namespace Tests\Feature\Auth;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/api/logout');

        $this->assertGuest();
    }

    public function test_me(): void
    {
        $role1 = Role::create(['name' => 'admin']);
        $role2 = Role::create(['name' => 'manager']);
        $role3 = Role::create(['name' => 'user']);


        Permission::create(['name' => 'admin-create']);
        Permission::create(['name' => 'manager-edit']);
        Permission::create(['name' => 'user-view']);

        $role1->givePermissionTo('admin-create');

        $user = User::factory()->create();
        $company = Company::factory()->create(['user_id' => $user->id]);
        $user->companies()->attach($company->id);


        $this->actingAs($user);

        $user->syncRoles([$role1, $role2, $role3]);

        $response = $this->getJson('/api/user');
        $response->assertStatus(200);
        $json = $response->json('data');
        $this->assertEquals($json['company']['id'], $company->id);
        $this->assertEquals($json['roles']['admin'][0], 'admin-create');
    }
}
