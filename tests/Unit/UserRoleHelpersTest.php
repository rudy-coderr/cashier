<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserRoleHelpersTest extends TestCase
{
    use RefreshDatabase;

    private function roleId(string $name): int
    {
        return DB::table('roles')->where('name', $name)->value('id');
    }

    public function test_role_name_returns_lowercase_name_for_known_role(): void
    {
        $user = User::factory()->create(['role_id' => $this->roleId('admin')]);
        $this->assertSame('admin', $user->roleName());
    }

    public function test_role_name_returns_null_when_role_id_is_null(): void
    {
        $user = User::factory()->create(['role_id' => null]);
        $this->assertNull($user->roleName());
    }

    public function test_dashboard_route_returns_correct_route_for_each_role(): void
    {
        $cases = [
            'admin'      => 'admin.dashboard',
            'maker'      => 'dashboard',
            'reviewer'   => 'reviewer',
            'accountant' => 'accountant.approval',
        ];

        foreach ($cases as $roleName => $expectedRoute) {
            $user = User::factory()->create(['role_id' => $this->roleId($roleName)]);
            $this->assertSame($expectedRoute, $user->dashboardRoute(), "Failed for role: {$roleName}");
        }
    }

    public function test_dashboard_route_returns_dashboard_when_no_role(): void
    {
        $user = User::factory()->create(['role_id' => null]);
        $this->assertSame('dashboard', $user->dashboardRoute());
    }
}
