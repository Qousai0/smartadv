<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_returns_user_details_role_and_token()
    {
        $role = Role::create(['name' => 'student']);
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $role->id,
        ]);

        $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password123',
        ])
            ->assertOk()
            ->assertJsonPath('user.id', $user->id)
            ->assertJsonPath('user.role.name', 'student')
            ->assertJsonPath('user.is_admin', false)
            ->assertJsonStructure(['token', 'token_type'])
            ->assertJsonMissingPath('user.password');
    }

    public function test_public_registration_cannot_create_an_admin()
    {
        $this->postJson('/api/register', [
            'name' => 'New User',
            'email' => 'new@example.com',
            'password' => 'password123',
            'role' => 'admin',
        ])
            ->assertCreated()
            ->assertJsonPath('user.role.name', 'user')
            ->assertJsonPath('user.is_admin', false);
    }

    public function test_only_admins_can_create_users_with_selected_roles()
    {
        $userRole = Role::create(['name' => 'user']);
        $adminRole = Role::create(['name' => 'admin']);
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $adminRole->id,
        ]);

        $this->actingAs($admin, 'sanctum')
            ->postJson('/api/users', [
                'name' => 'Another Admin',
                'email' => 'another-admin@example.com',
                'password' => 'password123',
                'role' => 'admin',
            ])
            ->assertCreated()
            ->assertJsonPath('user.role.name', 'admin')
            ->assertJsonPath('user.is_admin', true);

        $ordinaryUser = User::create([
            'name' => 'Ordinary User',
            'email' => 'ordinary@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $userRole->id,
        ]);

        $this->actingAs($ordinaryUser, 'sanctum')
            ->postJson('/api/users', [
                'name' => 'Blocked User',
                'email' => 'blocked@example.com',
                'password' => 'password123',
                'role' => 'user',
            ])
            ->assertForbidden();
    }
}
