<?php

namespace Zohaib\SimpleRbac\Traits;

use Illuminate\Support\Collection;
use Zohaib\SimpleRbac\Models\Role;

trait HasRoles
{
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function assignRole(...$roles): self
    {
        $roles = collect($roles)->flatten()->map(function ($role) {
            return $role instanceof Role ? $role : Role::where('name', $role)->firstOrFail();
        });

        $this->roles()->syncWithoutDetaching($roles->pluck('id'));

        return $this;
    }

    public function hasRole(...$roles): bool
    {
        $roles = collect($roles)->flatten();

        return $this->roles->whereIn('name', $roles)->isNotEmpty();
    }

    public function hasAnyRole(...$roles): bool
    {
        return $this->roles->whereIn('name', collect($roles)->flatten())->isNotEmpty();
    }

    public function getAllPermissions(): Collection
    {
        return $this->roles->flatMap->permissions->unique('id');
    }

    public function hasPermissionTo(...$permissions): bool
    {
        return $this->getAllPermissions()->whereIn('name', collect($permissions)->flatten())->isNotEmpty();
    }
}
