<?php

namespace App\Traits;

use App\Models\Role;

trait HasRoles
{
  public function roles()
  {
    return $this->belongsToMany(Role::class)->withTimestamps();
  }

  public function hasRole($roleName)
  {
    return $this->roles()->where('name', $roleName)->exists();
  }

  public function assignRole($roleName)
  {
    $role = Role::where('name', $roleName)->first();
    if ($role && !$this->hasRole($roleName)) {
      $this->roles()->attach($role);
    }
    return $this;
  }

  public function removeRole($roleName)
  {
    $role = Role::where('name', $roleName)->first();
    if ($role) {
      $this->roles()->detach($role);
    }
    return $this;
  }

  public function isAdmin()
  {
    return $this->hasRole('admin');
  }

  public function isCollector()
  {
    return $this->hasRole('collector');
  }

  public function isRegularUser()
  {
    return $this->hasRole('user');
  }
}
