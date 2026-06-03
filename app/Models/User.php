<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'first_name',
        'middle_name',
        'last_name',
        'username',
        'email',
        'password',
        'phone_number',
        'address',
        'position',
        'status',
        'profile_picture',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roleName(): ?string
    {
        if (empty($this->role_id)) {
            return null;
        }
        $name = DB::table('roles')->where('id', $this->role_id)->value('name');
        return $name ? strtolower($name) : null;
    }

    public function dashboardRoute(): string
    {
        return match ($this->roleName()) {
            'admin'      => 'admin.dashboard',
            'maker'      => 'dashboard',
            'reviewer'   => 'reviewer',
            'accountant' => 'accountant.approval',
            default      => 'dashboard',
        };
    }
}
