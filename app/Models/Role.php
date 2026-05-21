<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $guarded = ['id'];

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    public function admins(): BelongsToMany
    {
        return $this->belongsToMany(Admin::class);
    }

    public function hasPermission(string $slug): bool
    {
        return $this->permissions()->where('slug', $slug)->exists();
    }

    public function hasAnyPermission(array $slugs): bool
    {
        return $this->permissions()->whereIn('slug', $slugs)->exists();
    }

    public function hasAllPermissions(array $slugs): bool
    {
        $count = $this->permissions()->whereIn('slug', $slugs)->count();

        return $count === count($slugs);
    }
}
