<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Check if user has specific role
     */
    protected function hasRole($role)
    {
        return auth()->check() && auth()->user()->hasRole($role);
    }

    /**
     * Check if user is admin
     */
    protected function isAdmin()
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if user is collector
     */
    protected function isCollector()
    {
        return $this->hasRole('collector');
    }

    /**
     * Check if user is regular user
     */
    protected function isRegularUser()
    {
        return $this->hasRole('user');
    }
}
