<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'is_approved',
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
        ];
    }

    /**
     * Helper to quickly check if the user has admin privileges.
     */
    public function isAdmin(): bool
    {
        return isset($this->role) && strcasecmp($this->role, 'admin') === 0;
    }

    /**
     * Check if user has active access (lifetime or non-expired trial) to a feature.
     */
    public function hasAccessTo(string $featureCode): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        $access = $this->accesses()
            ->where('feature_code', strtolower($featureCode))
            ->first();

        if (!$access) {
            return false;
        }

        if ($access->is_trial && $access->expires_at && now()->greaterThan($access->expires_at)) {
            return false;
        }

        return true;
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function accesses()
    {
        return $this->hasMany(UserAccess::class);
    }
}
