<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RequireRoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    private function userWithRole(string $role): User
    {
        $roleId = DB::table('roles')->where('name', $role)->value('id');
        return User::factory()->create([
            'role_id' => $roleId,
            'status'  => 'active',
        ]);
    }

    public function test_reviewer_hitting_admin_route_is_redirected_to_reviewer_dashboard(): void
    {
        $reviewer = $this->userWithRole('reviewer');

        $this->actingAs($reviewer)
            ->get('/admin')
            ->assertRedirect(route('reviewer'));
    }

    public function test_maker_hitting_admin_route_is_redirected_to_maker_dashboard(): void
    {
        $maker = $this->userWithRole('maker');

        $this->actingAs($maker)
            ->get('/admin')
            ->assertRedirect(route('dashboard'));
    }

    public function test_accountant_hitting_admin_route_is_redirected_to_accountant_dashboard(): void
    {
        $accountant = $this->userWithRole('accountant');

        $this->actingAs($accountant)
            ->get('/admin')
            ->assertRedirect(route('accountant.approval'));
    }

    public function test_admin_can_access_admin_route(): void
    {
        $admin = $this->userWithRole('admin');

        $this->actingAs($admin)
            ->get('/admin')
            ->assertStatus(200);
    }
}
