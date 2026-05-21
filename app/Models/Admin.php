<?php

namespace App\Models;

use App\Notifications\AdminNotificationMail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public function sendPasswordResetNotification($token)
    {
        return $this->notify(new AdminNotificationMail($token));
    }

    protected $fillable = [
        'name',
        'email',
        'password',
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

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole(string $slug): bool
    {
        return $this->roles()->where('slug', $slug)->exists();
    }

    public function hasAnyRole(array $slugs): bool
    {
        return $this->roles()->whereIn('slug', $slugs)->exists();
    }

    public function hasPermission(string $slug): bool
    {
        foreach ($this->roles as $role) {
            if ($role->hasPermission($slug)) {
                return true;
            }
        }

        return false;
    }

    public function hasAnyPermission(array $slugs): bool
    {
        foreach ($this->roles as $role) {
            if ($role->hasAnyPermission($slugs)) {
                return true;
            }
        }

        return false;
    }

    public function hasAllPermissions(array $slugs): bool
    {
        foreach ($slugs as $slug) {
            if (! $this->hasPermission($slug)) {
                return false;
            }
        }

        return true;
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super-admin');
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(AdminActivityLog::class);
    }

    public function assignedDeliveries(): HasMany
    {
        return $this->hasMany(Order::class, 'assigned_delivery_admin_id');
    }

    public function deliveryTrackings(): HasMany
    {
        return $this->hasMany(DeliveryTracking::class);
    }
}
