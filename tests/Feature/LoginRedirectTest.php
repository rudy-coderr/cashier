<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LoginRedirectTest extends TestCase
{
    use RefreshDatabase;

    private function userWithRole(string $role, string $password = 'password'): User
    {
        $roleId = DB::table('roles')->where('name', $role)->value('id');
        return User::factory()->create([
            'role_id'  => $roleId,
            'password' => bcrypt($password),
            'status'   => 'active',
        ]);
    }

    private function attemptLogin(User $user, string $password = 'password')
    {
        return $this->post('/login', [
            'email'    => $user->email,
            'password' => $password,
        ]);
    }

    public function test_admin_is_redirected_to_admin_dashboard_after_login(): void
    {
        $user = $this->userWithRole('admin');
        $this->attemptLogin($user)->assertRedirect(route('admin.dashboard'));
    }

    public function test_maker_is_redirected_to_maker_dashboard_after_login(): void
    {
        $user = $this->userWithRole('maker');
        $this->attemptLogin($user)->assertRedirect(route('dashboard'));
    }

    public function test_reviewer_is_redirected_to_reviewer_dashboard_after_login(): void
    {
        $user = $this->userWithRole('reviewer');
        $this->attemptLogin($user)->assertRedirect(route('reviewer'));
    }

    public function test_accountant_is_redirected_to_accountant_dashboard_after_login(): void
    {
        $user = $this->userWithRole('accountant');
        $this->attemptLogin($user)->assertRedirect(route('accountant.approval'));
    }

    public function test_wrong_password_does_not_redirect_to_dashboard(): void
    {
        $user = $this->userWithRole('admin');
        $this->withHeader('Referer', url('/login'))
            ->attemptLogin($user, 'wrongpassword')
            ->assertRedirect('/login');
    }
}
