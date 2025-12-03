<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }

    public function counts(): HasMany
    {
        return $this->hasMany(Count::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function hasRole(UserRole|string $role): bool
    {
        $current = $this->role instanceof UserRole ? $this->role->value : $this->role;
        $target = $role instanceof UserRole ? $role->value : $role;

        return $current === $target;
    }

    public function hasAnyRole(array $roles): bool
    {
        $current = $this->role instanceof UserRole ? $this->role->value : $this->role;
        $values = array_map(fn($role) => $role instanceof UserRole ? $role->value : $role, $roles);

        return in_array($current, $values, true);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(UserRole::ADMIN);
    }

    public function isKeeper(): bool
    {
        return $this->hasRole(UserRole::KEEPER);
    }

    public function isAuditor(): bool
    {
        return $this->hasRole(UserRole::AUDITOR);
    }

    public function isSupervisor(): bool
    {
        return $this->hasRole(UserRole::SPV);
    }
}
