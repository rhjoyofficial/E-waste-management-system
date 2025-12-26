<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isCollector()
    {
        return $this->hasRole('collector');
    }

    public function isUser()
    {
        return $this->hasRole('user');
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

    // Relationships
    public function submittedRequests()
    {
        return $this->hasMany(EwasteRequest::class, 'user_id');
    }

    public function assignedRequests()
    {
        return $this->hasMany(EwasteRequest::class, 'collector_id');
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
